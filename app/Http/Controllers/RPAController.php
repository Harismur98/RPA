<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Process;
use App\Models\ProcessStep;
use App\Models\ProcessTask;
use App\Models\FileImg;
use App\Models\Job_template;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;

class RPAController extends Controller
{
    public function processIndex(){
        $process = Process::where('delete_by', '=', 1) -> get();

        return view('components.process', compact('process'));
    }

    public function getProcesses(Request $request){
        // Fetch processes (you can still cache if needed)
        $processes = Process::where('delete_by', '=', 1) -> get();

        // Return the processes as a JSON response
        return response()->json($processes);
    }

    public function processStore(){
        $validated = request()->validate([
            'process_name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        $validated['create_by'] = Auth::id();

        Process::create($validated);

        return redirect()->route('rpa.process.index')->with('success', 'Process created successfully.');
    }

    public function processEdit($id){
        $process = Process::find($id);

        return response()->json($process);
    }

    public function processDestroy($id){
        $process = Process::find($id);

        $process->delete_by = Auth::id();
        $process->save();

        return redirect()->route('rpa.process.index')->with('success', 'Process deleted successfully.');
    }

    public function process_step_index(Request $request)
    {
        $processId = $request->query('process_id');

        // Validate processId if necessary
        if (!$processId) {
            return response()->json(['error' => 'Process ID is required'], 400);
        }

        $processSteps = ProcessStep::where('process_id', $processId)
                                ->where('delete_by', '=', 1)
                                ->get();

        return response()->json($processSteps);
    }

    public function process_step_store(Request $request)
    {
        $validated = $request->validate([
            'step_name' => 'required|string|max:255',
            'process_id' => 'required|integer',
            'description' => 'string|max:255',
        ]);

        $validated['create_by'] = Auth::id();

        $processStep = ProcessStep::create($validated);

        return response()->json($processStep);
    }

    public function process_task_index(Request $request)
    {
        $processStepId = $request->query('step_id');

        // Validate processStepId if necessary
        if (!$processStepId) {
            return response()->json(['error' => 'Process Step ID is required'], 400);
        }

        $processTasks = ProcessTask::where('step_id', $processStepId)
                                ->where('delete_by', '=', 1)
                                ->get();

        return response()->json($processTasks);
    }

    public function process_task_store(Request $request)
    {
        try{
            $request->merge([
                'confidence' => (int) $request->input('confidence'),
                'order' => (int) $request->input('order'),
            ]);

            $validated = $request->validate([
                'task_name' => 'required|string|max:255',
                'step_id' => 'required|integer',
                'description' => 'string|max:255',
                'confidence' => 'required|integer',
                'order' => 'required|integer',
                'is_loop' => 'required|boolean',
                'is_stop_task' => 'required|boolean',
                'value' => 'string|max:255',
            ]);

            
            
            $validated['create_by'] = Auth::id();

            $processTask = ProcessTask::create($validated);
            
            if ($request->hasFile('file1') || $request->hasFile('file2') || $request->hasFile('file3')) {
                $file1 = $request->file('file1');
                $file2 = $request->file('file2');
                $file3 = $request->file('file3');

                // Store file1
                if ($file1) {
                    $fileName = $file1->getClientOriginalName();
                    $file1Path = $file1->store('uploads', 'public');

                    $fileImg1 = new FileImg();
                    $fileImg1->filename = $fileName;
                    $fileImg1->file_path = $file1Path;
                    $fileImg1->file_index = 1;
                    $fileImg1->original_name = $fileName;
                    $fileImg1->process_task_id = $processTask->id;
                    $fileImg1->save();
                }

                // Store file2
                if ($file2) {
                    $fileName = $file2->getClientOriginalName();
                    $file2Path = $file2->store('uploads', 'public');
        
                    $fileImg2 = new FileImg();
                    $fileImg2->filename = $fileName;
                    $fileImg2->file_path = $file2Path;
                    $fileImg2->file_index = 2;
                    $fileImg2->original_name = $fileName;
                    $fileImg2->process_task_id = $processTask->id;
                    $fileImg2->save();
                }

                // Store file3
                if ($file3) {
                    $fileName = $file3->getClientOriginalName();
                    $file3Path = $file3->store('uploads', 'public');
        
                    $fileImg3 = new FileImg();
                    $fileImg3->filename = $fileName;
                    $fileImg3->file_path = $file3Path;
                    $fileImg3->file_index = 3;
                    $fileImg3->original_name = $fileName;
                    $fileImg3->process_task_id = $processTask->id;
                    $fileImg3->save();
                }
            }
            return response()->json($processTask);
        }
        catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function template_index(){
        $template = Job_template::where('delete_by', '=', 1) ->with(['process', 'vm']) -> get();

        // $processes = Cache::remember('processes', 600, function () {
        //     return Process::all();
        // });

        return view('components.job_template', compact('template'));
    }

    public function template_store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'process_id' => 'required|integer',
            'description' => 'string|max:255',
            'vm_id' => 'required|integer',
        ]);

        // Log the validated data
        Log::info('Validated template data:', $validated);

        // Add the authenticated user ID
        $validated['create_by'] = Auth::id();

        // Log the user ID
        Log::info('Template created by user:', ['user_id' => $validated['create_by']]);

        // Create the job template
        Job_template::create($validated);

        // Log success message
        Log::info('Job template created successfully:', ['name' => $validated['name']]);

        // Redirect with success message
        // dd($validated);
        return redirect()->route('rpa.template.index')->with('success', 'Template created successfully.');
    }

    public function addJob(Request $request)
    {
        $selectedJobId = $request->input('selected_job_id');
        
        // Handle the selected job ID (e.g., assign a job, redirect, etc.)
        
        // Example: Redirect with success message
        return redirect()->route('rpa.template.index')->with('success', 'Job added successfully!');
    }
}
