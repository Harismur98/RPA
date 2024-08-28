<?php

namespace App\Http\Controllers;

use App\Models\VM;
use Illuminate\Http\Request;

class VMController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $vms = VM::all();
        return view('vm', compact('vms'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('vm.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
            'last_handshake' => 'nullable|date',
            'delete_by' => 'nullable|string|max:255',
            'create_by' => 'nullable|string|max:255',
        ]);

        VM::create($validated);

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
        $vm = VM::findOrFail($id);
        $vm->delete();

        return redirect()->route('vms.index')->with('success', 'VM deleted successfully.');
    }
}
