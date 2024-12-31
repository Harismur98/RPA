@extends('layout.app')

@section('content')
<div class="main-panel">
    @include('components.navbarHeader')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Panels</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Base</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Panels</a>
                    </li>
                </ul>
            </div>

                <ul class="nav nav-pills mb-3" id="process-tab-navigation" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="process-tab" data-bs-toggle="tab" href="#process-content" role="tab" aria-controls="process-content" aria-selected="true">
                            Process
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="step-tab" data-bs-toggle="tab" href="#step-content" role="tab" aria-controls="step-content" aria-selected="false">
                            Step
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="task-tab" data-bs-toggle="tab" href="#task-content" role="tab" aria-controls="task-content" aria-selected="false">
                            Task
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                    <!-- The process table column -->
                    <div class="tab-pane fade show active" id="process-content" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12" id="process-table-container">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex align-items-center">
                                                <h4 class="card-title">Process</h4>
                                                <button class="btn btn-primary btn-round ms-auto" id="addProcessButton">
                                                    <i class="fa fa-plus"></i>
                                                    Add Process
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="vm-table" class="display table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Process Name</th>
                                                        <th>Description</th>
                                                        <th style="width: 10%">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Process Name</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        @foreach($process as $p)
                                                            <tr id="process-row-{{$p->id}}" >
                                                                <td>{{ $p->process_name }}</td>
                                                                <td>{{ $p->description }}</td>
                                                                <td>
                                                                    <div class="form-button-action">
                                                                        <a href="{{ route('rpa.process.edit', $p->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit Task">
                                                                            <i class="fa fa-edit"> Edit</i>
                                                                        </a>
                                                                        <button class="btn btn-link btn-danger" onclick="deleteItem({{ $p->id }},'process')">Delete</button>
                                                                        <button class="btn btn-link btn-info" data-process-id="{{ $p->id }}" onclick="toggleProcessView(this)">
                                                                            <i class="fa fa-eye"></i> View Step
                                                                        </button>
                                                                        <button class="btn btn-link btn-info" data-process-id="{{ $p->id }}"  onclick="showProcessDetails(this)">
                                                                            <i class="fa fa-eye"></i> View Process
                                                                        </button>
                                                                        
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @if($process->isEmpty())
                                                            <tr>
                                                                <td colspan="3">No processes found.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>                                
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
        
                                    <!-- Process detail hidden at start -->
                                    <div class="col-md-6" id="process-info-container" style="display: none;">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-flex align-items-center">
                                                    <h4 class="card-title">Process Details</h4>
                                                    <button class="btn btn-danger btn-xs ms-auto" id="remove_process_details">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p id="process-info-name"><strong>Name:</strong> <span></span></p>
                                                <p id="process-info-description"><strong>Description:</strong> <span></span></p>
                                                <!-- Add other fields as necessary -->
                                            </div>
                                        </div>
                                    </div>
                
                                    <!-- The form column, hidden initially -->
                                    <div class="col-md-6" id="process-form-container" style="display: none;">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Add New Process</h4>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('rpa.process.store') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" name="process_name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control" name="description" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Save Process</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                    <!-- The process step table, hidden initially -->
                    <div class="tab-pane fade" id="step-content" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12" id="process-step-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Process Steps</h4>
                                            <button class="btn btn-primary btn-round ms-auto" id="addProcessStepButton" onclick="showAddStepForm()">
                                                <i class="fa fa-plus"></i>
                                                Add Step
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="process-step-table" class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Step Name</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="process-step-table-body">
                                                    <!-- Dynamic rows will be appended here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                                <div class="col-md-6" id="step-info-container" style="display: none;">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex align-items-center">
                                                <h4 class="card-title">Step Details</h4>
                                                <button class="btn btn-danger btn-xs ms-auto" id="remove_step_details">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p id="step-info-name"><strong>Name:</strong> <span></span></p>
                                            <p id="step-info-description"><strong>Description:</strong> <span></span></p>
                                            <!-- Add other fields as necessary -->
                                        </div>
                                    </div>
                                </div>
            
            
                                <!-- The form column, hidden initially -->
                                <div class="col-md-6" id="process-step-form-container" style="display: none;">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Add New Process Step</h4>
                                        </div>
                                        <div class="card-body">
                                            <form id="process-step-form" method="POST">
                                                @csrf
                                                <input type="hidden" id="process-id" name="process_id">
                                                <div class="form-group">
                                                    <label for="name">Step Name</label>
                                                    <input type="text" class="form-control" name="step_name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description" required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Save Step</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    <!-- The process task table, hidden initially -->
                    <div class="tab-pane fade" id="task-content" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12" id="process-task-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Process Task</h4>
                                            <button class="btn btn-primary btn-round ms-auto" id="addProcessTaskButton" onclick="showAddTaskForm()">
                                                <i class="fa fa-plus"></i>
                                                Add Task
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="process-task-table" class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Task Name</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="process-task-table-body">
                                                    <!-- Dynamic rows will be appended here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-md-6" id="task-info-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Task Details</h4>
                                            <button class="btn btn-danger btn-xs ms-auto" id="remove_task_details">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p id="task-info-name"><strong>Name:</strong> <span></span></p>
                                        <p id="task-info-description"><strong>Description:</strong> <span></span></p>
                                        <p id="task-info-action"><strong>Action:</strong> <span></span></p>
                                        <p id="task-info-confidence"><strong>Confidence:</strong> <span></span></p>
                                        <p id="task-info-order"><strong>Order:</strong> <span></span></p>
                                        <p id="task-info-loop"><strong>Is Loop:</strong> <span></span></p>
                                        <p id="task-info-stop"><strong>Stop Task:</strong> <span></span></p>
                                        <p id="task-info-value"><strong>Value:</strong> <span></span></p>
                                        <p id="task-info-step"><strong>Step ID:</strong> <span></span></p>
                                        <p id="task-info-created"><strong>Created By:</strong> <span></span></p>
                                        
                                        <div id="task-images" class="mt-3">
                                            <!-- Images will be dynamically added here -->
                                        </div>
                                    </div>
                                </div>
                            </div>                
        
                            <!-- The form column, hidden initially -->
                            <div class="col-md-6" id="process-task-form-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Process Task</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="process-task-form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="step-id" name="step_id">
                                            <div class="form-group">
                                                <label for="name">Task Name</label>
                                                <input type="text" class="form-control" name="task_name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="task action">Task Action</label>
                                                <select class="form-select" name="task_action" required>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" name="description" ></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="value">Value</label>
                                                <input type="text" class="form-control" name="value" >
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="confidence">Confidence</label>
                                                        <input type="text" class="form-control" name="confidence" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="order">Order</label>
                                                        <input type="text" class="form-control" name="order" >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="is_loop">Is Loop?</label>
                                                        <input type="text" class="form-control" name="is_loop" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="is_stop_task">Is Stop Task?</label>
                                                        <input type="text" class="form-control" name="is_stop_task" >
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Click</label><br>
                                                        <div class="d-flex">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="click" value="single">
                                                                    <label class="form-check-label" for="click">
                                                                        Single
                                                                    </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="click" value="double">
                                                                    <label class="form-check-label" for="click">
                                                                        Double
                                                                    </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="image1">Image 1</label>
                                                        <input type="file" class="form-control" name="file1" accept="image/*" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="image2">Image 2</label>
                                                        <input type="file" class="form-control" name="file2" accept="image/*" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="image3">Image 3</label>
                                                        <input type="file" class="form-control" name="file3" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Save Task</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" id="task-exception-container" style="display: block;">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Task Exception</h4>
                                            <button class="btn btn-primary btn-round ms-auto" id="addProcessTaskButton" onclick="showAddExceptionForm()">
                                                <i class="fa fa-plus"></i>
                                                Add Exception
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="process-exception-table" class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Exception Name</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="process-exception-table-body">
                                                    <!-- Dynamic rows will be appended here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" id="task-exception-info-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Exception Details</h4>
                                            <button class="btn btn-danger btn-xs ms-auto" id="remove_exception_details">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p id="exception-info-name"><strong>Name:</strong> <span></span></p>
                                        <p id="exception-info-description"><strong>Description:</strong> <span></span></p>
                                        <p id="exception-info-action"><strong>Action:</strong> <span></span></p>
                                        <p id="exception-info-confidence"><strong>Confidence:</strong> <span></span></p>
                                        <p id="exception-info-order"><strong>Order:</strong> <span></span></p>
                                        <p id="exception-info-loop"><strong>Is Loop:</strong> <span></span></p>
                                        <p id="exception-info-stop"><strong>Stop Task:</strong> <span></span></p>
                                        <p id="exception-info-value"><strong>Value:</strong> <span></span></p>
                                        <p id="exception-info-step"><strong>Step ID:</strong> <span></span></p>
                                        <p id="exception-info-created"><strong>Created By:</strong> <span></span></p>
                                        
                                        <div id="excetion-images" class="mt-3">
                                            <!-- Images will be dynamically added here -->
                                        </div>
                                    </div>
                                </div>
                            </div>     
                            
                            <div class="col-md-6" id="task-exception-form-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Task Exception</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="task-exception-form" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="step-id2" name="step_id">
                                            <div class="form-group">
                                                <label for="name">Exception Name</label>
                                                <input type="text" class="form-control" name="exception_name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exception action">Exception Action</label>
                                                <select class="form-select" name="task_action" required>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" name="description" ></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="value">Value</label>
                                                <input type="text" class="form-control" name="value" >
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="confidence">Confidence</label>
                                                        <input type="text" class="form-control" name="confidence" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="order">Order</label>
                                                        <input type="text" class="form-control" name="order" >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="is_loop">Is Loop?</label>
                                                        <input type="text" class="form-control" name="is_loop" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="is_stop_task">Is Stop Exception?</label>
                                                        <input type="text" class="form-control" name="is_stop_exception" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="image1">Image 1</label>
                                                        <input type="file" class="form-control" name="file1" accept="image/*" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="image2">Image 2</label>
                                                        <input type="file" class="form-control" name="file2" accept="image/*" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="image3">Image 3</label>
                                                        <input type="file" class="form-control" name="file3" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Save Exception</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
    </div>

    @include('components.footer')

    <script>
        const table = new DataTable('#vm-table');
        document.getElementById('addProcessButton').addEventListener('click', function() {
            // Change the table's grid from col-md-12 to col-md-6
            document.getElementById('process-table-container').classList.remove('col-md-12');
            document.getElementById('process-table-container').classList.add('col-md-6');

            // Show the form container
            document.getElementById("process-info-container").style.display = "none";
            document.getElementById('process-form-container').style.display = 'block';
        });

        function toggleProcessView(button) {
            let processTableContainer = document.getElementById('process-table-container');
            let processStepContainer = document.getElementById('process-step-container');
            let stepsTab = document.getElementById('step-tab');
            

            // Ensure the process table stays visible and positioned at the top
            processTableContainer.classList.add('col-md-12'); // Full-width by default
            processStepContainer.style.display = 'block'; // Ensure steps are visible

            // Load the relevant process steps for the clicked process
            let processId = button.getAttribute('data-process-id');
            document.getElementById('process-id').value = processId;
            loadProcessSteps(processId);
            let pillsTab = new bootstrap.Tab(stepsTab);
            pillsTab.show();
        }

        function toggleStepView(button) {
            let processTableContainer = document.getElementById('process-table-container');
            let processStepContainer = document.getElementById('process-step-container');
            let processTaskContainer = document.getElementById('process-task-container');
            let taskTab = document.getElementById('task-tab');

            // Ensure the process steps table stays visible and positioned at the top
            processStepContainer.classList.add('col-md-12'); // Full-width by default
            processTaskContainer.style.display = 'block'; // Ensure tasks are visible

            // Load the relevant tasks for the clicked step
            let stepId = button.getAttribute('data-step-id');
            document.getElementById('step-id').value = stepId;
            document.getElementById('step-id2').value = stepId;
            loadProcessTasks(stepId);
            loadProcessException(stepId);
            let pillsTab = new bootstrap.Tab(taskTab);
            pillsTab.show();
        }

        function loadProcessSteps(processId) {
            fetch("{{ route('rpa.process_step.index') }}?process_id=" + processId)
                .then(response => response.json())
                .then(data => {
                    let processStepTableBody = document.getElementById('process-step-table-body');
                    processStepTableBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(step => {
                            let row = `
                                <tr id="step-row-${step.id}">
                                    <td>${step.Step_name}</td>
                                    <td>${step.description}</td>
                                    <td>
                                        <!-- Action buttons for process steps -->
                                        <button class="btn btn-link btn-primary" onclick="editStep(${step.id})">Edit</button>
                                        <button class="btn btn-link btn-danger" onclick="deleteItem(${step.id},'step')">Delete</button>
                                        <button class="btn btn-link btn-info" data-step-id="${step.id}" onclick="toggleStepView(this)">
                                            <i class="fa fa-eye"></i> View Task
                                        </button>
                                        <button class="btn btn-link btn-info" data-step-id="${step.id}"  onclick="showStepDetails(this)">
                                            View Step
                                        </button>
                                    </td>
                                </tr>
                            `;
                            processStepTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        processStepTableBody.innerHTML = '<tr><td colspan="3">No steps found for this process.</td></tr>';
                    }
                })
                .catch(error => console.error('Error loading process steps:', error));
        }

        function loadProcessTasks(stepsId) {
            fetch("{{ route('rpa.process_task.index') }}?step_id=" + stepsId)
                .then(response => response.json())
                .then(data => {
                    let processTaskTableBody = document.getElementById('process-task-table-body');
                    processTaskTableBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(task => {
                            let row = `
                                <tr id="task-row-${task.id}">
                                    <td>${task.task_name}</td>
                                    <td>${task.description}</td>
                                    <td>
                                        <!-- Action buttons for process tasks -->
                                        <button class="btn btn-link btn-primary" onclick="editTask(${task.id})">Edit</button>
                                        <button class="btn btn-link btn-danger" onclick="deleteItem(${task.id},'task')">Delete</button>
                                        <button class="btn btn-link btn-info" data-process-id="${task.id}" onclick="toggleProcessView(this)">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-link btn-info" data-task-id="${task.id}"  onclick="showTaskDetails(this)">
                                            View Task
                                        </button>
                                    </td>
                                </tr>
                            `;
                            processTaskTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        processTaskTableBody.innerHTML = '<tr><td colspan="3">No Task found for this Step.</td></tr>';
                    }
                })
                .catch(error => console.error('Error loading process Task:', error));
        }

        function loadProcessException(stepsId) {
            fetch("{{ route('rpa.process_exception.index') }}?step_id=" + stepsId)
                .then(response => response.json())
                .then(data => {
                    let processTaskTableBody = document.getElementById('process-exception-table-body');
                    processTaskTableBody.innerHTML = '';

                    if (data.length > 0) {
                        console.log(data);
                        data.forEach(task => {
                            let row = `
                                <tr id="exception-row-${task.id}">
                                    <td>${task.exception_name}</td>
                                    <td>${task.description}</td>
                                    <td>
                                        <!-- Action buttons for process tasks -->
                                        <button class="btn btn-link btn-primary" onclick="editTask(${task.id})">Edit</button>
                                        <button class="btn btn-link btn-danger" onclick="deleteItem(${task.id},'exception')">Delete</button>
                                        <button class="btn btn-link btn-info" data-task-id="${task.id}"  onclick="showExeptionDetails(this)">
                                            View Exception
                                        </button>
                                    </td>
                                </tr>
                            `;
                            processTaskTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        processTaskTableBody.innerHTML = '<tr><td colspan="3">No Exception found for this Step.</td></tr>';
                    }
                })
                .catch(error => console.error('Error loading process Task:', error));
        }

        function showAddStepForm() {
            document.getElementById('process-step-container').classList.remove('col-md-12');
            document.getElementById('process-step-container').classList.add('col-md-6');
            document.getElementById("step-info-container").style.display = "none";
            document.getElementById('process-step-form-container').style.display = 'block';
        }

        function showAddTaskForm() {
            document.getElementById('process-task-container').classList.remove('col-md-12');
            document.getElementById('process-task-container').classList.add('col-md-6');
            document.getElementById('process-task-form-container').style.display = 'block';
            document.getElementById("task-info-container").style.display = "none";
            fetch("{{ route('rpa.action.api') }}")
            .then(response => response.json())
            .then(data => {
                let taskActionSelect = document.querySelector('#process-task-form select');

                // Clear existing options
                taskActionSelect.innerHTML = '';

                // Add options dynamically based on API data
                data.forEach(action => {
                    let option = document.createElement('option');
                    option.value = action.id; // Assuming `id` is the unique identifier
                    option.textContent = action.function_name; // Assuming `name` is the label for the action
                    taskActionSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading task actions:', error));
        }

        function showAddExceptionForm() {
            document.getElementById('task-exception-container').classList.remove('col-md-12');
            document.getElementById('task-exception-container').classList.add('col-md-6');
            document.getElementById('task-exception-form-container').style.display = 'block';
            document.getElementById("task-exception-info-container").style.display = "none";
            fetch("{{ route('rpa.action.api') }}")
            .then(response => response.json())
            .then(data => {
                let exceptionActionSelect = document.querySelector('#task-exception-form select');

                // Clear existing options
                exceptionActionSelect.innerHTML = '';

                // Add options dynamically based on API data
                data.forEach(action => {
                    let option = document.createElement('option');
                    option.value = action.id; // Assuming `id` is the unique identifier
                    option.textContent = action.function_name; // Assuming `name` is the label for the action
                    exceptionActionSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading task actions:', error));
        }

        function editStep(stepId) {
            console.log("Edit step with ID:", stepId);
        }

        function deleteItem(itemId, type) {
            const confirmMessage = `Are you sure you want to delete this ${type}?`;
            const routeUrl = {
                task: "{{ route('rpa.process_task.destroy', '') }}/",
                step: "{{ route('rpa.process_step.destroy', '') }}/",
                process: "{{ route('rpa.process.destroy', '') }}/",
                exception: "{{ route('rpa.process_exception.destroy', '') }}/"
            };

            if (confirm(confirmMessage)) {
                fetch(routeUrl[type] + itemId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the deleted item row from the table
                        document.getElementById(`${type}-row-${itemId}`).remove();


                        //kena remove table yg terbukak


                        
                        console.log(`${type.charAt(0).toUpperCase() + type.slice(1)} deleted successfully.`);
                    } else {
                        console.error(`Failed to delete ${type}:`, data.message);
                    }
                })
                .catch(error => console.error(`Error deleting ${type}:`, error));
            }
        }

        document.getElementById('process-step-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            let formData = new FormData(this);
            let processId = document.getElementById('process-id').value;
            let formAction = "{{ route('rpa.process_step.store') }}";

            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // Add the new process step to the table
                let processStepTableBody = document.getElementById('process-step-table-body');
                let row = `
                    <tr>
                        <td>${data.step_name}</td>
                        <td>${data.description}</td>
                        <td>
                            <button class="btn btn-link btn-primary" onclick="editStep(${data.id})">Edit</button>
                            <button class="btn btn-link btn-danger" onclick="deleteStep(${data.id})">Delete</button>
                            <button class="btn btn-link btn-info" data-step-id="{${data.id}}"  onclick="showStepDetails(this)">
                                 View Step
                            </button>
                        </td>
                    </tr>
                `;
                processStepTableBody.insertAdjacentHTML('beforeend', row);

                // Clear the form fields
                document.getElementById('process-step-form').reset();
                document.getElementById('process-step-form-container').style.display = 'none';
            })
            .catch(error => console.error('Error adding process step:', error));
        });

        document.getElementById('process-task-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            let formData = new FormData(this);
            let processId = document.getElementById('step-id').value;
            let formAction = "{{ route('rpa.process_task.store') }}";

            let formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            console.log("Form data as JSON:", JSON.stringify(formObject));
            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                return response.text().then(text => {
                    try {
                        // Attempt to parse the response as JSON
                        return JSON.parse(text);
                    } catch (error) {
                        // Log the response text if JSON parsing fails
                        console.error("Non-JSON response:", text);
                        throw new Error("The response is not valid JSON.");
                    }
                });
            })
            .then(data => {
                // Add the new process step to the table
                let processTaskTableBody = document.getElementById('process-task-table-body');
                let row = `
                    <tr id="step-row-${data.id}">
                        <td>${data.task_name}</td>
                        <td>${data.description}</td>
                        <td>
                            <button class="btn btn-link btn-primary" onclick="editTask(${data.id})">Edit</button>
                            <button class="btn btn-link btn-danger" onclick="deleteItem(${data.id},'task')">Delete</button>
                            <button class="btn btn-link btn-info" data-task-id="${data.id}"  onclick="showTaskDetails(this)">
                                View Task
                            </button>
                        </td>
                    </tr>
                `;
                processTaskTableBody.insertAdjacentHTML('beforeend', row);

                // Clear the form fields
                document.getElementById('process-task-form').reset();
                document.getElementById('process-task-form-container').style.display = 'none';
            })
            .catch(error => console.error('Error adding process task:', error));
        });

        document.getElementById('task-exception-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            let formData = new FormData(this);
            let processId = document.getElementById('step-id').value;
            let formAction = "{{ route('rpa.process_exception.store') }}";

            let formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            console.log("Form data as JSON:", JSON.stringify(formObject));
            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                return response.text().then(text => {
                    try {
                        // Attempt to parse the response as JSON
                        return JSON.parse(text);
                    } catch (error) {
                        // Log the response text if JSON parsing fails
                        console.error("Non-JSON response:", text);
                        throw new Error("The response is not valid JSON.");
                    }
                });
            })
            .then(data => {
                
                
                // Add the new process step to the table
                let processTaskTableBody = document.getElementById('process-exception-table-body');
                let noExceptionRow = processTaskTableBody.querySelector('tr td[colspan="3"]');
                if (noExceptionRow) {
                    noExceptionRow.parentElement.remove();
                }
                let row = `
                    <tr id="exception-row-${data.id}">
                        <td>${data.exception_name}</td>
                        <td>${data.description}</td>
                        <td>
                            <button class="btn btn-link btn-primary" onclick="editTask(${data.id})">Edit</button>
                            <button class="btn btn-link btn-danger" onclick="deleteItem(${data.id},'exception')">Delete</button>
                            <button class="btn btn-link btn-info" data-task-id="${data.id}"  onclick="showExceptionDetails(this)">
                                View Exception
                        </td>
                    </tr>
                `;
                processTaskTableBody.insertAdjacentHTML('beforeend', row);

                // Clear the form fields
                document.getElementById('task-exception-form').reset();
                document.getElementById('task-exception-form-container').style.display = 'none';
                document.getElementById('task-exception-container').classList.remove('col-md-6');
                document.getElementById('task-exception-container').classList.add('col-md-12');
            })
            .catch(error => console.error('Error adding process exception:', error));
        });

        function showProcessDetails(row){
            const processID = row.getAttribute('data-process-id');

            fetch("{{ route('rpa.get.processes', ':id') }}".replace(':id', processID))
            .then((response) => response.json())
            .then((data) => {
                for(let i = 0; i<1; i++){
                    document.querySelector("#process-info-name span").innerText = data[i].process_name;
                    document.querySelector("#process-info-description span").innerText = data[i].description;

                    document.getElementById('process-table-container').classList.remove('col-md-12');
                    document.getElementById('process-table-container').classList.add('col-md-6');

                    document.getElementById('process-form-container').style.display = 'none';
                    document.getElementById("process-info-container").style.display = "block";
                }
                
            })
            .catch((error) => console.error("Error fetching process details:", error));
        }

        document.getElementById('remove_process_details').addEventListener('click', function(event){
            document.getElementById('process-table-container').classList.remove('col-md-6');
            document.getElementById('process-table-container').classList.add('col-md-12');

            // Show the form container
            document.getElementById("process-info-container").style.display = "none";
        });

        function showStepDetails(row){
            const stepID = row.getAttribute('data-step-id');

            fetch("{{ route('rpa.get.step', ':id') }}".replace(':id', stepID))
            .then((response) => response.json())
            .then((data) => {
                for(let i = 0; i<1; i++){
                    document.querySelector("#step-info-name span").innerText = data[i].step_name;
                    document.querySelector("#step-info-description span").innerText = data[i].description;

                    document.getElementById('process-step-container').classList.remove('col-md-12');
                    document.getElementById('process-step-container').classList.add('col-md-6');

                    document.getElementById('process-step-form-container').style.display = 'none';
                    document.getElementById("step-info-container").style.display = "block";
                }
                
            })
            .catch((error) => console.error("Error fetching step details:", error));
        }

        document.getElementById('remove_step_details').addEventListener('click', function(event){
            document.getElementById('process-step-container').classList.remove('col-md-6');
            document.getElementById('process-step-container').classList.add('col-md-12');

            // Show the form container
            document.getElementById("step-info-container").style.display = "none";
        });

        function showTaskDetails(row) {
            const taskID = row.getAttribute('data-task-id');

            fetch("{{ route('rpa.get.task', ':id') }}".replace(':id', taskID))
                .then((response) => response.json())
                .then((data) => {
                    if (data.length > 0) {
                        const task = data[0]; // Assuming one task is returned

                        // Update task details
                        document.querySelector("#task-info-name span").innerText = task.task_name;
                        document.querySelector("#task-info-description span").innerText = task.description;

                        document.querySelector("#task-info-action span").innerText = task.task_action;
                        document.querySelector("#task-info-confidence span").innerText = task.confidence + '%';
                        document.querySelector("#task-info-order span").innerText = task.order;
                        document.querySelector("#task-info-loop span").innerText = task.is_loop ? "Yes" : "No";
                        document.querySelector("#task-info-stop span").innerText = task.is_stop_task ? "Yes" : "No";
                        document.querySelector("#task-info-value span").innerText = task.value;
                        document.querySelector("#task-info-step span").innerText = task.step_id;
                        document.querySelector("#task-info-created span").innerText = task.create_by;

                        // Update layout
                        document.getElementById('process-task-container').classList.remove('col-md-12');
                        document.getElementById('process-task-container').classList.add('col-md-6');
                        document.getElementById('process-task-form-container').style.display = 'none';
                        document.getElementById("task-info-container").style.display = "block";

                        // Handle images
                        const imageContainer = document.getElementById('task-images');
                        imageContainer.innerHTML = ''; // Clear previous images
                        const assetBaseUrl = "{{ asset('storage/') }}/";
                        if (task.img && task.img.length > 0) {
                            task.img.forEach(image => {
                                const imgElement = document.createElement('img');
                                imgElement.src = assetBaseUrl + image.file_path; // Assuming `file_path` contains the image URL
                                imgElement.alt = task.task_name;
                                imgElement.className = 'img-fluid mb-2'; // Add Bootstrap classes for styling
                                imageContainer.appendChild(imgElement);
                            });
                        } else {
                            const noImageMessage = document.createElement('p');
                            noImageMessage.innerText = 'No images available for this task.';
                            imageContainer.appendChild(noImageMessage);
                        }
                    }
                })
                .catch((error) => console.error("Error fetching task details:", error));
        }


        document.getElementById('remove_task_details').addEventListener('click', function(event){
            document.getElementById('process-task-container').classList.remove('col-md-6');
            document.getElementById('process-task-container').classList.add('col-md-12');

            // Show the form container
            document.getElementById("task-info-container").style.display = "none";
        });

        
    </script>
</div>
@endsection