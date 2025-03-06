<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Process;
use App\Models\ProcessStep;
use App\Models\ProcessTask;
use App\Models\ProcessException;
use App\Models\FileImg;
use App\Models\Job_template;
use App\Models\RPA_action;
use App\Models\step_exception;
use App\Models\Job;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Auth;

class RPAController extends Controller
{
    public function processIndex(){
        $process = Process::where('delete_by', '=', 1) -> get();

        // return view('components.process.index', compact('process')); //testing new structure
        return view('components.process', compact('process'));
    }

    public function getProcesses($id){
        // Fetch processes (you can still cache if needed)
        $processes = Process::where('delete_by', '=', 1) -> where('id', '=', $id) -> get();

        // Return the processes as a JSON response
        return response()->json($processes);
    }

    public function getProcess(){
        $process = Process::where('delete_by', '=', 1) -> get();

        return response()->json($process);
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

    public function processUpdate($id, Request $request){
        $process = Process::find($id);

        if ($request->isMethod('PUT')) {
            $validated = $request->validate([
                'process_name' => 'required|string|max:255',
                'description' => 'string|max:255',
            ]);

            $process->process_name = $validated['process_name'];
            $process->description = $validated['description'];
            $process->save();

            return redirect()->route('rpa.process.index')->with('success', 'Process Updated successfully.');
        }

        return response()->json($process);
    }

    public function processDestroy($id){
        $process = Process::find($id);

        $process->delete_by = Auth::id();
        $process->save();

        return response()->json([
            'success' => true,
            'message' => 'Process deleted successfully',
        ]);
    }

    public function process_step_index(Request $request){
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

    public function process_step_store(Request $request){
        $validated = $request->validate([
            'step_name' => 'required|string|max:255',
            'process_id' => 'required|integer',
            'description' => 'string|max:255',
        ]);

        $validated['create_by'] = Auth::id();

        $processStep = ProcessStep::create($validated);

        return response()->json($processStep);
    }

    public function process_step_update($id, Request $request){
        $step = ProcessStep::find($id);

        if ($request->isMethod('PUT')) {
            $validated = $request->validate([
                'step_name' => 'required|string|max:255',
                'description' => 'string|max:255',
            ]);

            $step->step_name = $validated['step_name'];
            $step->description = $validated['description'];
            $step->save();

            return response()->json($step);
        }

        return response()->json($step);
    }

    public function process_step_destroy($id){
        $step = ProcessStep::find($id);

        $step->delete_by = Auth::id();
        $step->save();

        return response()->json([
            'success' => true,
            'message' => 'Step deleted successfully',
        ]);
    }

    public function getStep($id){

        $step = ProcessStep::where('delete_by', '=', 1) -> where('id', '=', $id) -> get();

        return response()->json($step);
    }

    public function process_task_index(Request $request){
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

    public function getTask($id){

        $task = ProcessTask::with('img')
                            ->where('delete_by', '=', 1) 
                            -> where('id', '=', $id) 
                            -> get();
        return response()->json($task);
    }

    public function process_task_store(Request $request){
        
        try{
            $request->merge([
                'confidence' => (int) $request->input('confidence'),
                'order' => (int) $request->input('order'),
                'description' => $request->input('description') ?? '',
                'value' => (string) ($request->input('value') ?? ''),
                'step_id' => (int) $request->input('step_id'),
            ]);

            $validated = $request->validate([
                'task_name' => 'required|string|max:255',
                'step_id' => 'required|integer',
                'description' => 'string|max:255',
                'confidence' => 'integer',
                'order' => 'integer',
                'is_stop_task' => 'boolean',
                'value' => 'string|max:255',
                'task_action' => 'required|integer',
                'condition_type' => 'nullable|string|in:' . implode(',', array_column(\App\Enums\ConditionType::cases(), 'value')),
            ]);
            
            $validated['create_by'] = Auth::id();

            $processTask = ProcessTask::create($validated);
            
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $index => $file) {
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->store('uploads', 'public');
    
                    FileImg::create([
                        'filename' => $fileName,
                        'file_path' => $filePath,
                        'file_index' => $index + 1,
                        'original_name' => $fileName,
                        'process_task_id' => $processTask->id,
                    ]);
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

    public function process_task_update($id, Request $request){
        $task = ProcessTask::find($id);
        
        if ($request->isMethod('PUT')) {

            $request->merge([
                'confidence' => (int) $request->input('confidence'),
                'order' => (int) $request->input('order'),
                'description' => $request->input('description') ?? '',
                'value' => (string) ($request->input('value') ?? ''),
            ]);

            $validated = $request->validate([
                'task_name' => 'required|string|max:255',
                'description' => 'string|max:255',
                'confidence' => 'integer',
                'order' => 'integer',
                'is_stop_task' => 'boolean',
                'value' => 'string|max:255',
                'task_action' => 'required|integer',
                'condition_type' => 'nullable|string|in:' . implode(',', array_column(\App\Enums\ConditionType::cases(), 'value')),
            ]);

            $task->task_name = $validated['task_name'];
            $task->description = $validated['description'];
            $task->confidence = $validated['confidence'];
            $task->order = $validated['order'];
            $task->is_stop_task = $validated['is_stop_task'];
            $task->value = $validated['value'];
            $task->task_action = $validated['task_action'];
            $task->condition_type = $validated['condition_type'];
            $task->save();
            
            if ($request->hasFile('files')) {
                FileImg::where('process_task_id', $task->id)->delete();
                foreach ($request->file('files') as $index => $file) {
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->store('uploads', 'public');
    
                    FileImg::create([
                        'filename' => $fileName,
                        'file_path' => $filePath,
                        'file_index' => $index + 1,
                        'original_name' => $fileName,
                        'process_task_id' => $task->id,
                    ]);
                }
            }
            return response()->json($task);
        }
        return response()->json($task);
    }

    public function process_task_destroy($id){
        $task = ProcessTask::find($id);

        $task->delete_by = Auth::id();
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully',
        ]);
    }

    public function process_step_exception_index(Request $request){
        $stepId = $request->query('step_id');

        // Validate processId if necessary
        if (!$stepId) {
            return response()->json(['error' => 'Step ID is required'], 400);
        }

        $processSteps = step_exception::where('step_id', $stepId)
                                ->where('delete_by', '=', 1)
                                ->get();

        return response()->json($processSteps);
    }

    public function process_step_exception_store(Request $request){

        try {
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'step_id' => 'required|integer',
            'description' => 'string|max:255',
            ]);
            
            $validated['create_by'] = Auth::id();
        } catch (ValidationException $e) {
            return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
            ], 422);
        }
        
        $processStep = step_exception::create($validated);

        return response()->json($processStep);
    }

    public function process_step_exception_update($id, Request $request){
        $step = step_exception::find($id);

        if ($request->isMethod('PUT')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'string|max:255',
            ]);

            $step->name = $validated['name'];
            $step->description = $validated['description'];
            $step->save();

            return response()->json($step);
        }

        return response()->json($step);
    }

    public function process_step_exception_destroy($id){
        $step = step_exception::find($id);

        $step->delete_by = Auth::id();
        $step->save();

        return response()->json([
            'success' => true,
            'message' => 'Step deleted successfully',
        ]);
    }

    public function getStepException($id){

        $step = step_exception::where('delete_by', '=', 1) -> where('id', '=', $id) -> get();

        return response()->json($step);
    }

    public function process_exception_index(Request $request){
        $processStepId = $request->query('step_id');

        // Validate processStepId if necessary
        if (!$processStepId) {
            return response()->json(['error' => 'Process Step ID is required'], 400);
        }

        $processTasks = ProcessException::where('step_id', $processStepId)
                                ->where('delete_by', '=', 1)
                                ->get();

        return response()->json($processTasks);
    }

    public function getException($id){

        $exception = ProcessException::with('img')
                            ->where('delete_by', '=', 1) 
                            -> where('id', '=', $id) 
                            -> get();
        return response()->json($exception);
    }

    public function process_exception_store(Request $request){
        
        try{
            $request->merge([
                'confidence' => (int) $request->input('confidence'),
                'order' => (int) $request->input('order'),
                'is_loop' => $request->input('is_loop') === null ? 0 : 1,
                'is_stop_task' => $request->input('is_stop_task') === null ? 0 : 1,
                'description' => $request->input('description') ?? '',
                'value' => (string) ($request->input('value') ?? ''),
            ]);
            

            $validated = $request->validate([
                'exception_name' => 'required|string|max:255',
                'step_id' => 'required|integer',
                'description' => 'string|max:255',
                'confidence' => 'integer',
                'order' => 'integer',
                'is_loop' => 'boolean',
                'is_stop_task' => 'boolean',
                'value' => 'string|max:255',
                'task_action' => 'required|integer',
            ]);

            Log::info($request->all());
            
            $validated['create_by'] = Auth::id();

            $processException = ProcessException::create($validated);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $index => $file) {
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->store('uploads', 'public');
    
                    FileImg::create([
                        'filename' => $fileName,
                        'file_path' => $filePath,
                        'file_index' => $index + 1,
                        'original_name' => $fileName,
                        'process_exception_id' => $processException->id,
                    ]);
                }
            }

            return response()->json($processException);
        }
        catch (ValidationException $e) {
            Log::info($request->all());
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function process_exception_update($id, Request $request){
        $task = ProcessException::find($id);
        
        if ($request->isMethod('PUT')) {

            $request->merge([
                'confidence' => (int) $request->input('confidence'),
                'order' => (int) $request->input('order'),
                'description' => $request->input('description') ?? '',
                'value' => (string) ($request->input('value') ?? ''),
            ]);

            $validated = $request->validate([
                'exception_name' => 'required|string|max:255',
                'description' => 'string|max:255',
                'confidence' => 'integer',
                'order' => 'integer',
                'is_loop' => 'boolean',
                'is_stop_exception' => 'boolean',
                'value' => 'string|max:255',
                'task_action' => 'required|integer',
            ]);

            $task->exception_name = $validated['exception_name'];
            $task->description = $validated['description'];
            $task->confidence = $validated['confidence'];
            $task->order = $validated['order'];
            $task->is_loop = $validated['is_loop'];
            $task->is_stop_task = $validated['is_stop_exception'];
            $task->value = $validated['value'];
            $task->task_action = $validated['task_action'];
            $task->save();
            
            

            if ($request->hasFile('files')) {
                //delete old image files
                FileImg::where('process_exception_id', $task->id)->delete();

                foreach ($request->file('files') as $index => $file) {
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->store('uploads', 'public');
    
                    FileImg::create([
                        'filename' => $fileName,
                        'file_path' => $filePath,
                        'file_index' => $index + 1,
                        'original_name' => $fileName,
                        'process_exception_id' => $task->id,
                    ]);
                }
            }
            
            return response()->json($task);
        }
        
        return response()->json($task);
    }

    public function process_exception_destroy($id){
        $task = ProcessException::find($id);

        $task->delete_by = Auth::id();
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully',
        ]);
    }

    public function template_index(){
        $template = Job_template::where('delete_by', '=', 1) ->with(['process', 'vm']) -> get();

        // $processes = Cache::remember('processes', 600, function () {
        //     return Process::all();
        // });

        return view('components.job_template', compact('template'));
    }

    public function template_store(Request $request){
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

    public function updateTemplate(Request $request){
        $request->validate([
            'id' => 'required|exists:job_templates,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'process_id' => 'nullable|exists:process,id',
            'vm_id' => 'nullable|integer',
        ]);

        $template = Job_template::findOrFail($request->id);
        $template->name = $request->name;
        $template->description = $request->description;
        $template->process_id = $request->process_id;
        $template->vm_id = $request->vm_id;
        $template->save();

        return redirect()->back()->with('success', 'Template updated successfully.');
    }

    public function template_destroy($id){
        $template = Job_template::find($id);

        $template->delete_by = Auth::id();
        $template->save();

        return response()->json([
            'success' => true,
            'message' => 'Template deleted successfully',
        ]);
    }

    public function addJob($id){
        $jobTemplate = Job_template::findOrFail($id);
        $processId = $jobTemplate->process_id;
        
        if (!$processId) {
            return response()->json(['message' => 'No associated process found for this template.'], 404);
        }
        
        // Retrieve the process
        $process = Process::findOrFail($processId);
        
        // Retrieve all steps associated with the process_id
        $processSteps = ProcessStep::where('process_id', $processId)->where('delete_by', '=', 1)->get();
        
        // Initialize arrays for the formatted data
        $processDetails = [ 
            'process_id' => $process->id,
            'process_name' => $process->name,
            'step_ids' => $processSteps->pluck('id')->toArray(),
        ];
        
        $stepDetails = [];
        $taskDetails = [];
        
        foreach ($processSteps as $step) {
            $tasks = $step->tasks; 
            $tasks = $step->tasks()->orderBy('order', 'asc')->get(); 
            $stepDetails[] = [
                'step_id' => $step->id,
                'step_name' => $step->Step_name,
                'task_ids' => $tasks->pluck('id')->toArray(),
            ];
            //sort tasks by order
            $tasks = $tasks->sortBy('order');
            foreach ($tasks as $task) {
                $taskDetails[] = [
                    'task_id' => $task->id,
                    'task_name' => $task->task_name,
                    'task_action' => $task->task_action,
                    'confidence' => $task->confidence,
                    'order' => $task->order,
                    'is_loop' => $task->is_loop,
                    'is_stop_task' => $task->is_stop_task,
                    'value' => $task->value,
                    'img' => $task->img,
                ];
            }
        }
        
        $processData = [
            'process_details' => $processDetails,
            'step_details' => $stepDetails,
            'task_details' => $taskDetails,
        ];
        
        // dd($processData);
        $apiKey = $jobTemplate->vm->api_key;
        // Store the job in the job queue
        $job = Job::create([
            'api_key' => $apiKey, // Assuming the template has a `vm_id` field
            'status' => 'pending',
            'data' => json_encode($processData), // Store the structured data in the database
        ]);
        
        return response()->json([
            'message' => 'Job added successfully',
            'job_id' => $job->id,
        ], 201);
    }

    public function getJobsForVm($api_key){
        $jobs = Job::where('api_key', $api_key)
                    ->where('status', 'pending')
                    ->get();

        return response()->json($jobs);
    }

    public function updateJobStatus(Request $request, $api_key ,$job_id){
        $job = Job::findOrFail($job_id);
 
        $job->update([
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Job updated successfully']);
    }

    public function rpa_action_index(){
        $actions = RPA_action::where('delete_by', '=', 1) -> get();

        return view('components.rpa_action', compact('actions'));
    }

    public function rpa_action_store(){
        $validated = request()->validate([
            'function_name' => 'required|string|max:255',
        ]);

        $validated['create_by'] = Auth::id();

        RPA_action::create($validated);

        return redirect()->route('rpa.action.index')->with('success', 'Process created successfully.');
    }

    public function rpa_action_delete(){
        $validated = request()->validate([
            'function_name' => 'required|string|max:255',
        ]);

        $validated['create_by'] = Auth::id();

        RPA_action::create($validated);

        return redirect()->route('rpa.action.index')->with('success', 'Process created successfully.');
    }

    public function rpa_action_api(){
        $actions = RPA_action::where('delete_by', '=', 1) -> get();

        return response()->json($actions);
    }

    
}
