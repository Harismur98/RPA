<?php

namespace App\Http\Controllers;

use App\Models\VM;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VMController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $vms = VM::all();
        return view('components.vm', compact('vms'));
    }

    public function getVM(Request $request){
        // Fetch processes (you can still cache if needed)
        $vms = VM::all();

        // Return the processes as a JSON response
        return response()->json($vms);
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('vm.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
            'delete_by' => 'nullable|exists:users,id', // Ensure this is valid if provided
        ]);

        // If 'delete_by' is not provided, it will be null, which is valid for nullable columns
        $validated['create_by'] = Auth::id(); // Set the current user's ID

        // Create a new VM with the validated data
        VM::create($validated);

        // Redirect to the VM index page with success message
        return redirect()->route('vms.index')->with('success', 'VM created successfully.');
    }


    // Display the specified resource.
    public function show($id)
    {
        $vm = VM::findOrFail($id);
        return view('vm.show', compact('vm'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $vm = VM::findOrFail($id);
        return view('vm.edit', compact('vm'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
            'last_handshake' => 'nullable|date',
            'delete_by' => 'nullable|string|max:255',
            'create_by' => 'nullable|string|max:255',
        ]);

        $vm = VM::findOrFail($id);
        $vm->update($validated);

        return redirect()->route('vms.index')->with('success', 'VM updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Find the VM by ID
        $vm = VM::findOrFail($id);

        // Update the delete_by field with the current user's ID
        $vm->update([
            'delete_by' => Auth::id(),
        ]);

        // Perform the actual deletion if needed
        $vm->delete();

        return redirect()->route('vms.index')->with('success', 'VM deleted successfully.');
    }

    public function generateApiKey()
    {
        // Generate a unique API key
        $apiKey = Str::random(32);

        // Return the API key as a JSON response
        return response()->json(['api_key' => $apiKey]);
    }
}
