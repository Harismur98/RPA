<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->paginate(10);
        return view('jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    public function getJobStatus($id)
    {
        $job = Job::findOrFail($id);
        return response()->json([
            'status' => $job->status,
            'result' => $job->result,
            'data' => $job->data
        ]);
    }

    public function stop($id)
    {
        $job = Job::findOrFail($id);
        $job->status = 'stopped';
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Job stopped successfully');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully');
    }
} 