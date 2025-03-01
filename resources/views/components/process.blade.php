@extends('layout.app')

@section('content')
<div class="main-panel">
    @include('components.navbarHeader')
<style>
        /* * {
        box-sizing: border-box;
    } */

    input[type="file"] {
        position: absolute;
        right: -9999px;
        visibility: hidden;
        opacity: 0;
    }
    /* input[type="submit"] {
        position: relative;
        padding: 1rem 3rem;
        background: #0c8fda;
        display: inline-block;
        text-align: center;
        overflow: hidden;
        border-radius: 10px;
        border: 0;
        color:#fff;
        &:hover {
            background: darken(#0c8fda, 5);
            color: #fff;
            cursor: pointer;
            transition: 0.2s all;
        } */
    }
    /* label {
        position: relative;
        padding: 1rem 3rem;
        background: #eee;
        display: inline-block;
        text-align: center;
        overflow: hidden;
        border-radius: 10px;
        &:hover {
            background: #0c8fda;
            color: #fff;
            cursor: pointer;
            transition: 0.2s all;
        }
    } */

    div {
        &.files {
            background: #eee;
            padding: 1rem;
            margin:1rem 0;
            border-radius:10px;
            ul{
                list-style:none;
                padding:0;
                max-height:150px;
                overflow:auto;
                li{
                    padding:0.5rem 0;
                    padding-right:2rem;
                    position:relative;
                    i{
                        cursor:pointer;
                        position:absolute;
                        top:50%;
                        right:0;
                        transform:translatey(-50%);
                    }
                }
            }
        }
        &.container {
            width: 100%;
            padding: 0 2rem;
        }
    }

    span.file-size {
        color: #999;
        padding-left: 0.5rem;
    }

</style>
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
                                                                        <a href="#" class="btn btn-link btn-primary btn-lg" 
                                                                            data-bs-toggle="tooltip" 
                                                                            title="Edit Task" 
                                                                            onclick="editProcess({{ $p->id }}, '{{ $p->process_name }}', '{{ $p->description }}' , '{{ route('rpa.process.edit', $p->id) }}')">
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
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h4 class="card-title">Add New Process</h4>
                                                <button type="button" class="close" onclick="closeProcessForm('process')" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
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
                                                    <div class="form-group d-flex justify-content-between mt-3">
                                                        <button type="submit" class="btn btn-primary">Save Process</button>
                                                        <button type="button" class="btn btn-secondary" onclick="closeProcessForm('process')">Cancel</button>
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
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Add Step</h4>
                                            <button type="button" class="close" onclick="closeProcessForm('step')" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
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
                                                <div class="form-group d-flex justify-content-between mt-3">
                                                    <button type="submit" class="btn btn-primary">Save Step</button>
                                                    <button type="button" class="btn btn-secondary" onclick="closeProcessForm('step')">Cancel</button>
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
                                                        <th>Order</th>
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
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Add New Process Task</h4>
                                        <button type="button" class="close" onclick="closeProcessForm('task')" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
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
                                                        <div class="d-flex">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="is_loop" id="is_loop_yes" value="1">
                                                                <label class="form-check-label" for="is_loop_yes">Yes</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="is_loop" id="is_loop_no" value="0">
                                                                <label class="form-check-label" for="is_loop_no">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="is_stop_task">Is Stop Task?</label>
                                                        <div class="d-flex">
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" name="is_stop_task" id="flexRadioDefault1"value="1">
                                                              <label class="form-check-label" for="flexRadioDefault1" >
                                                                Yes
                                                              </label>
                                                            </div>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio"  name="is_stop_task" id="flexRadioDefault2" value="0"/>
                                                              <label class="form-check-label" for="flexRadioDefault2" >
                                                                No
                                                              </label>
                                                            </div>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- <div class="col-md-4">
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
                                                </div> --}}
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="uploadTask">
                                                            <input type="file" id="uploadTask" name="files[]" multiple>
                                                            Upload Files
                                                        </label>
                                                        
                                                        <div class="files">
                                                            <h2>Files Selected</h2>
                                                            <ul id="file-list-task"></ul>
                                                        </div>
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
                            <div class="col-md-12" id="process-step-exception-container" style="display: block;">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Step Exception</h4>
                                            <button class="btn btn-primary btn-round ms-auto" id="addStepExceptionButton" onclick="showAddStepExceptionForm()">
                                                <i class="fa fa-plus"></i>
                                                Add Step Exception
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="step-exception-table" class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Step Exception</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="process-step-exception-table-body">
                                                    <!-- Dynamic rows will be appended here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" id="step-exception-info-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Step Exception Details</h4>
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

                            <!-- Step Exception Form -->
                            <div class="col-md-6" id="process-step-exception-form-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Add Step Exception</h4>
                                        <button type="button" class="close" onclick="closeProcessForm('step-exception')" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <form id="process-step-exception-form" method="POST">
                                            @csrf
                                            <input type="hidden" id="step-id3" name="step_id">
                                            <div class="form-group">
                                                <label for="name">Step Exception Name</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" name="description" ></textarea>
                                            </div>
                                            <div class="form-group d-flex justify-content-between mt-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="button" class="btn btn-secondary" onclick="closeProcessForm('step-exception')">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12" id="task-exception-container" style="display: none;">
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
                                                        <th>Order</th>
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

                            <div class="col-md-6" id="exception-info-container" style="display: none;">
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
                                        <p id="exception-info-ID"><strong>Id:</strong> <span></span></p>
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
                                        
                                        <div id="exception-images" class="mt-3">
                                            <!-- Images will be dynamically added here -->
                                        </div>
                                    </div>
                                </div>
                            </div>     
                            
                            <!-- Task Exception Form -->
                            <div class="col-md-6" id="task-exception-form-container" style="display: none;">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Add Task Exception</h4>
                                        <button type="button" class="close" onclick="closeProcessForm('task-exception')" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
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
                                                        <div class="d-flex">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="is_loop" id="is_loop_yes" value="1">
                                                                <label class="form-check-label" for="is_loop_yes">Yes</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="is_loop" id="is_loop_no" value="0">
                                                                <label class="form-check-label" for="is_loop_no">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="is_stop_task">Is Stop Exception?</label>
                                                        <div class="d-flex">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="is_stop_exception" id="is_stop_exception_yes" value="1">
                                                                <label class="form-check-label" for="is_stop_exception_yes">Yes</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="is_stop_exception" id="is_stop_exception_no" value="0">
                                                                <label class="form-check-label" for="is_stop_exception_no">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- <div class="col-md-4">
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
                                                </div> --}}
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="uploadException">
                                                            <input type="file" id="uploadException" name="files[]" multiple>
                                                            Upload Files
                                                        </label>
                                                        
                                                        <div class="files">
                                                            <h2>Files Selected</h2>
                                                            <ul id="file-list-exception"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex justify-content-between mt-3">
                                                <button type="submit" class="btn btn-primary">Save Exception</button>
                                                <button type="button" class="btn btn-secondary" onclick="closeProcessForm('task-exception')">Cancel</button>
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

            // Reset form fields and title
            const form = document.querySelector('#process-form-container form');
            form.action = '/rpa/process/store'; // Update with your store route
            form.method = 'POST'; // Default method

            // Remove the hidden method input if it exists
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();

            // Reset form fields
            form.reset();

            document.querySelector('#process-form-container .card-title').textContent = 'Add Process';
            
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
            document.getElementById('step-id3').value = stepId;
            loadProcessTasks(stepId);
            loadProcessStepsException(stepId);
            let pillsTab = new bootstrap.Tab(taskTab);
            pillsTab.show();
        }

        function toggleStepExceptionView(button) {
            let stepId = button.getAttribute('data-step-exception-id');

            document.getElementById('step-id2').value = stepId;
            document.getElementById('task-exception-container').style.display = 'block';
            loadProcessException(stepId);
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
                                    <td>${step.step_name}</td>
                                    <td>${step.description}</td>
                                    <td>
                                        <!-- Action buttons for process steps -->
                                        <button class="btn btn-link btn-primary" onclick="editStep(${step.id}, '${step.step_name}', '${step.description}')">Edit</button>
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

        function loadProcessStepsException(stepId) {
            fetch("{{ route('rpa.process_step_exception.index') }}?step_id=" + stepId)
                .then(response => response.json())
                .then(data => {
                    let processStepTableBody = document.getElementById('process-step-exception-table-body');
                    processStepTableBody.innerHTML = '';

                    if (data.length > 0) {
                        // console.log(data);
                        data.forEach(step => {
                            let row = `
                                <tr id="step_exception-row-${step.id}">
                                    <td>${step.name}</td>
                                    <td>${step.description}</td>
                                    <td>
                                        <!-- Action buttons for process steps -->
                                        <button class="btn btn-link btn-primary" onclick="editStepException(${step.id}, '${step.name}', '${step.description}')">Edit</button>
                                        <button class="btn btn-link btn-danger" onclick="deleteItem(${step.id},'step_exception')">Delete</button>
                                        <button class="btn btn-link btn-info" data-step-exception-id="${step.id}" onclick="toggleStepExceptionView(this)">
                                            <i class="fa fa-eye"></i> View Exception
                                        </button>
                                        <button class="btn btn-link btn-info" data-step-exception-id="${step.id}"  onclick="showStepExceptionDetails(this)">
                                            View Step
                                        </button>
                                    </td>
                                </tr>
                            `;
                            processStepTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        processStepTableBody.innerHTML = '<tr><td colspan="3">No step Exception found for this process.</td></tr>';
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
                        data = data.sort((a, b) => a.order - b.order);
                        data.forEach(task => {
                            let row = `
                                <tr id="task-row-${task.id}">
                                    <td>${task.task_name}</td>
                                    <td>${task.description}</td>
                                    <td>${task.order}</td>
                                    <td>
                                        <!-- Action buttons for process tasks -->
                                        <button class="btn btn-link btn-primary" onclick="editTask(${task.id})">Edit</button>
                                        <button class="btn btn-link btn-danger" onclick="deleteItem(${task.id},'task')">Delete</button>
                                        <button class="btn btn-link btn-info" data-task-id="${task.id}"  onclick="showTaskDetails(this)">
                                            View Task
                                        </button>
                                    </td>
                                </tr>
                            `;
                            processTaskTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        processTaskTableBody.innerHTML = '<tr><td colspan="4">No Task found for this Step.</td></tr>';
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
                                    <td>${task.order}</td>
                                    <td>
                                        <!-- Action buttons for process tasks -->
                                        <button class="btn btn-link btn-primary" onclick="editException(${task.id})">Edit</button>
                                        <button class="btn btn-link btn-danger" onclick="deleteItem(${task.id},'exception')">Delete</button>
                                        <button class="btn btn-link btn-info" data-exception-id="${task.id}"  onclick="showExceptionDetails(this)">
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
            document.getElementById('process-step-form-container').style.display = 'block';
        }

        function showAddStepExceptionForm() {
            document.getElementById('process-step-exception-container').classList.remove('col-md-12');
            document.getElementById('process-step-exception-container').classList.add('col-md-6');
            const form = document.querySelector('#process-step-exception-form-container form');
            form.reset();
            document.querySelector('#process-step-exception-form-container .card-title').textContent = 'Add Step Exception';
            document.getElementById("step-exception-info-container").style.display = "none";
            document.getElementById('process-step-exception-form-container').style.display = 'block';
        }

        function showAddTaskForm() {
            document.getElementById('process-task-container').classList.remove('col-md-12');
            document.getElementById('process-task-container').classList.add('col-md-6');
            document.getElementById('process-task-form-container').style.display = 'block';
            document.getElementById("task-info-container").style.display = "none";

            const form = document.querySelector('#process-task-form-container form');
            form.setAttribute('data-mode', 'add');
            form.reset();
            document.querySelector('#process-task-form-container .card-title').textContent = 'Add Task';

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
            document.getElementById("exception-info-container").style.display = "none";
            const form = document.querySelector('#task-exception-form-container form');
            form.setAttribute('data-mode', 'add');
            form.reset();
            document.querySelector('#task-exception-form-container .card-title').textContent = 'Add Exception';

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

        function deleteItem(itemId, type) {
            const confirmMessage = `Are you sure you want to delete this ${type}?`;
            const routeUrl = {
                task: "{{ route('rpa.process_task.destroy', '') }}/",
                step: "{{ route('rpa.process_step.destroy', '') }}/",
                process: "{{ route('rpa.process.destroy', '') }}/",
                exception: "{{ route('rpa.process_exception.destroy', '') }}/",
                step_exception: "{{ route('rpa.process_step_exception.destroy', '') }}/"
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
            event.preventDefault();

            const form = this;
            const mode = form.getAttribute('data-mode') || 'add'; // Default to 'add' if no mode is set
            const formData = new FormData(form);

            // Determine route based on mode
            let formAction;
            if (mode === 'edit') {
                const stepId = form.getAttribute('data-step-id');
                formAction = "{{ route('rpa.process_step.update', ':id') }}".replace(':id', stepId);
                formData.append('_method', 'PUT'); // Laravel method override for PUT
            } else {
                formAction = "{{ route('rpa.process_step.store') }}";
            }

            // Submit the form
            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (mode === 'edit') {
                    // Update existing row
                    const row = document.querySelector(`[data-step-id="${data.id}"]`).closest('tr');
                    row.querySelector('td:nth-child(1)').textContent = data.step_name;
                    row.querySelector('td:nth-child(2)').textContent = data.description;
                } else {
                    // Add new row
                    const processStepTableBody = document.getElementById('process-step-table-body');
                    const row = `
                        <tr id="step-row-${data.id}">
                            <td>${data.step_name}</td>
                            <td>${data.description}</td>
                            <td>
                                <button class="btn btn-link btn-primary" onclick="editStep(${data.id}, '${data.step_name}', '${data.description}')">Edit</button>
                                <button class="btn btn-link btn-danger" onclick="deleteItem(${data.id}, 'step')">Delete</button>
                                <button class="btn btn-link btn-info" data-step-id="${data.id}" onclick="toggleStepView(this)">
                                    <i class="fa fa-eye"></i> View Task
                                </button>
                                <button class="btn btn-link btn-info" data-step-id="${data.id}" onclick="showStepDetails(this)">
                                    View Step
                                </button>
                            </td>
                        </tr>
                    `;
                    processStepTableBody.insertAdjacentHTML('beforeend', row);
                }

                // Reset and hide form
                form.reset();
                form.removeAttribute('data-mode'); // Clear mode
                form.removeAttribute('data-step-id'); // Clear step ID
                document.getElementById('process-step-form-container').style.display = 'none';
                document.getElementById('process-step-container').classList.remove('col-md-6');
                document.getElementById('process-step-container').classList.add('col-md-12');
            })
            .catch(error => console.error('Error:', error));
        });

        document.getElementById('process-step-exception-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const form = this;
            const mode = form.getAttribute('data-mode') || 'add'; // Default to 'add' if no mode is set
            const formData = new FormData(form);

            // Determine route based on mode
            let formAction;
            if (mode === 'edit') {
                const stepId = form.getAttribute('data-step-exception-id');
                formAction = "{{ route('rpa.process_step_exception.update', ':id') }}".replace(':id', stepId);
                formData.append('_method', 'PUT'); // Laravel method override for PUT
            } else {
                formAction = "{{ route('rpa.process_step_exception.store') }}";
            }

            // Submit the form
            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (mode === 'edit') {
                    // Update existing row
                    const row = document.querySelector(`[data-step-exception-id="${data.id}"]`).closest('tr');
                    row.querySelector('td:nth-child(1)').textContent = data.name;
                    row.querySelector('td:nth-child(2)').textContent = data.description;
                } else {
                    // Add new row
                    const processStepTableBody = document.getElementById('process-step-exception-table-body');
                    const row = `
                        <tr id="step_exception-row-${data.id}">
                            <td>${data.name}</td>
                            <td>${data.description}</td>
                            <td>
                                <button class="btn btn-link btn-primary" onclick="editStepException(${data.id}, '${data.name}', '${data.description}')">Edit</button>
                                <button class="btn btn-link btn-danger" onclick="deleteItem(${data.id},'step_exception')">Delete</button>
                                <button class="btn btn-link btn-info" data-step-exception-id="${data.id}" onclick="toggleStepExceptionView(this)">
                                    <i class="fa fa-eye"></i> View Exception
                                </button>
                                <button class="btn btn-link btn-info" data-step-exception-id="${data.id}" onclick="showStepExceptionDetails(this)">
                                    View Step
                                </button>
                            </td>
                        </tr>
                    `;
                    processStepTableBody.insertAdjacentHTML('beforeend', row);
                }

                // Reset and hide form
                form.reset();
                form.removeAttribute('data-mode'); // Clear mode
                form.removeAttribute('data-step-exception-id'); // Clear step ID
                document.getElementById('process-step-exception-form-container').style.display = 'none';
                document.getElementById('process-step-exception-container').classList.remove('col-md-6');
                document.getElementById('process-step-exception-container').classList.add('col-md-12');
            })
            .catch(error => console.error('Error:', error));
        });


        document.getElementById('process-task-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const form = this;
            const mode = form.getAttribute('data-mode') || 'add'; // Default to 'add' if no mode is set
            const formData = new FormData(form);

            let formAction;
            if (mode === 'edit') {
                const taskId = form.getAttribute('data-task-id');
                formAction = "{{ route('rpa.process_task.update', ':id') }}".replace(':id', taskId);
                formData.append('_method', 'PUT'); // Laravel method override for PUT
            } else {
                formAction = "{{ route('rpa.process_task.store') }}";
            }

            let formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
                console.log(key, value)
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

                
                if (mode === 'edit') {
                    // Update existing row

                    const row = document.querySelector(`[data-task-id="${data.id}"]`).closest('tr');
                    row.querySelector('td:nth-child(1)').textContent = data.task_name;
                    row.querySelector('td:nth-child(2)').textContent = data.description;
                    row.querySelector('td:nth-child(3)').textContent = data.order;
                    // sortTable();
                } else {
                    // Add new row

                    const processExceptionTableBody = document.getElementById('process-task-table-body');
                    const row = `
                        <tr id="task-row-${data.id}"> 
                            <td>${data.task_name}</td>
                            <td>${data.description}</td>
                            <td>${data.order}</td>
                            <td>
                                <button class="btn btn-link btn-primary" onclick="editTask(${data.id}, '${data.exception_name}', '${data.description}')">Edit</button>
                                <button class="btn btn-link btn-danger" onclick="deleteItem(${data.id},'task')">Delete</button>
                                <button class="btn btn-link btn-info" data-task-id="${data.id}" onclick="showTaskDetails(this)">
                                    View Task
                                </button>
                            </td>
                        </tr>
                    `;
                     
                    processExceptionTableBody.insertAdjacentHTML('beforeend', row);
                     
                }
                sortTable(); 
                // Clear the form fields
                document.getElementById('process-task-form').reset();
                document.getElementById('process-task-form-container').style.display = 'none';
                document.getElementById('process-task-container').classList.remove('col-md-6');
                document.getElementById('process-task-container').classList.add('col-md-12');
            })
            .catch(error => console.error('Error adding process task:', error));
        });

        document.getElementById('task-exception-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const form = this;
            const mode = form.getAttribute('data-mode') || 'add'; // Default to 'add' if no mode is set
            const formData = new FormData(form);

            let formAction;
            if (mode === 'edit') {
                const exceptionId = form.getAttribute('data-exception-id');
                formAction = "{{ route('rpa.process_exception.update', ':id') }}".replace(':id', exceptionId);
                formData.append('_method', 'PUT'); // Laravel method override for PUT
            } else {
                formAction = "{{ route('rpa.process_exception.store') }}";
            }

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
                
                
                if (mode === 'edit') {
                    // Update existing row
                    const row = document.querySelector(`[data-exception-id="${data.id}"]`).closest('tr');
                    row.querySelector('td:nth-child(1)').textContent = data.exception_name;
                    row.querySelector('td:nth-child(2)').textContent = data.description;
                } else {
                    // Add new row
                    const processExceptionTableBody = document.getElementById('process-exception-table-body');
                    const row = `
                        <tr id="exception-row-${data.id}"> 
                            <td>${data.exception_name}</td>
                            <td>${data.description}</td>
                            <td>
                                <button class="btn btn-link btn-primary" onclick="editException(${data.id}, '${data.exception_name}', '${data.description}')">Edit</button>
                                <button class="btn btn-link btn-danger" onclick="deleteItem(${data.id},'exception')">Delete</button>
                                <button class="btn btn-link btn-info" data-exception-id="${data.id}" onclick="showExceptionDetails(this)">
                                    View Exception
                                </button>
                            </td>
                        </tr>
                    `;
                    processExceptionTableBody.insertAdjacentHTML('beforeend', row);
                }

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
            document.getElementById('process-info-container').style.display = 'none';
            document.getElementById('process-table-container').classList.remove('col-md-6');
            document.getElementById('process-table-container').classList.add('col-md-12');
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
            document.getElementById('step-info-container').style.display = 'none';
            document.getElementById('process-step-container').classList.remove('col-md-6');
            document.getElementById('process-step-container').classList.add('col-md-12');
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

        function showExceptionDetails(row) {
            const taskID = row.getAttribute('data-exception-id');

            fetch("{{ route('rpa.get.exception', ':id') }}".replace(':id', taskID))
                .then((response) => response.json())
                .then((data) => {
                    if (data.length > 0) {
                        const task = data[0]; // Assuming one task is returned

                        // Update task details
                        document.querySelector("#exception-info-ID span").innerText = task.id;
                        document.querySelector("#exception-info-name span").innerText = task.exception_name;
                        document.querySelector("#exception-info-description span").innerText = task.description;

                        document.querySelector("#exception-info-action span").innerText = task.task_action;
                        document.querySelector("#exception-info-confidence span").innerText = task.confidence + '%';
                        document.querySelector("#exception-info-order span").innerText = task.order;
                        document.querySelector("#exception-info-loop span").innerText = task.is_loop ? "Yes" : "No";
                        document.querySelector("#exception-info-stop span").innerText = task.is_stop_task ? "Yes" : "No";
                        document.querySelector("#exception-info-value span").innerText = task.value;
                        document.querySelector("#exception-info-step span").innerText = task.step_id;
                        document.querySelector("#exception-info-created span").innerText = task.create_by;

                        // Update layout
                        document.getElementById('task-exception-container').classList.remove('col-md-12');
                        document.getElementById('task-exception-container').classList.add('col-md-6');
                        document.getElementById('task-exception-form-container').style.display = 'none';
                        document.getElementById("exception-info-container").style.display = "block";

                        // Handle images
                        const imageContainer = document.getElementById('exception-images');
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

        document.getElementById('remove_exception_details').addEventListener('click', function(event){
            document.getElementById('task-exception-container').classList.remove('col-md-6');
            document.getElementById('task-exception-container').classList.add('col-md-12');

            // Show the form container
            document.getElementById("exception-info-container").style.display = "none";
        });

        function editProcess(id, name, description, route) {
            // Show the form container
            document.getElementById('process-table-container').classList.remove('col-md-12');
            document.getElementById('process-table-container').classList.add('col-md-6');
            document.getElementById('process-form-container').style.display = 'block';

            // Update form action and method
            const form = document.querySelector('#process-form-container form');
            form.action = route; // Update with your edit route
            form.method = 'POST'; // Use POST with hidden method override for PUT

            // Add hidden input for method override
            if (!form.querySelector('input[name="_method"]')) {
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            }

            // Populate form fields
            form.querySelector('input[name="process_name"]').value = name;
            form.querySelector('textarea[name="description"]').value = description;

            // Update form title
            document.querySelector('#process-form-container .card-title').textContent = 'Edit Process';
        }

        function editStep(stepId, name, description) {
            // Show the form container
            document.getElementById('process-step-container').classList.remove('col-md-12');
            document.getElementById('process-step-container').classList.add('col-md-6');
            document.getElementById('process-step-form-container').style.display = 'block';

            // Update form action and method
            const form = document.querySelector('#process-step-form');
            form.setAttribute('data-mode', 'edit');
            form.setAttribute('data-step-id', stepId);

            // Populate form fields
            form.querySelector('input[name="step_name"]').value = name;
            form.querySelector('textarea[name="description"]').value = description;

            // Update form title
            document.querySelector('#process-step-form-container .card-title').textContent = 'Edit Step';
        }

        function editStepException(stepId, name, description) {
            // Show the form container
            document.getElementById('process-step-exception-container').classList.remove('col-md-12');
            document.getElementById('process-step-exception-container').classList.add('col-md-6');
            document.getElementById('process-step-exception-form-container').style.display = 'block';

            // Update form action and method
            const form = document.querySelector('#process-step-exception-form');
            form.setAttribute('data-mode', 'edit');
            form.setAttribute('data-step-exception-id', stepId);

            // Populate form fields
            form.querySelector('input[name="name"]').value = name;
            form.querySelector('textarea[name="description"]').value = description;

            // Update form title
            document.querySelector('#process-step-exception-form-container .card-title').textContent = 'Edit Step Exception';
        }

        function editTask(taskId) {
            // Adjust the layout to show the form
            document.getElementById('process-task-container').classList.remove('col-md-12');
            document.getElementById('process-task-container').classList.add('col-md-6');
            document.getElementById('process-task-form-container').style.display = 'block';
            document.getElementById("task-info-container").style.display = "none";
            resetState('task');
            // Load task actions first
            fetch("{{ route('rpa.action.api') }}")
                .then(response => response.json())
                .then(actions => {
                    let taskActionSelect = document.querySelector('#process-task-form select[name="task_action"]');

                    // Clear existing options
                    taskActionSelect.innerHTML = '';

                    // Populate dropdown with task actions
                    actions.forEach(action => {
                        let option = document.createElement('option');
                        option.value = action.id; // Assuming `id` is the unique identifier
                        option.textContent = action.function_name; // Assuming `function_name` is the label for the action
                        taskActionSelect.appendChild(option);
                    });

                    // Fetch task details only after task actions are loaded
                    return fetch(`{{ route('rpa.get.task', ':id') }}`.replace(':id', taskId));
                })
                .then(response => response.json())
                .then(firstdata => {
                    const form = document.getElementById('process-task-form');
                    form.setAttribute('data-task-id', taskId); // Store the task ID
                    form.setAttribute('data-mode', 'edit'); // Set mode to 'edit'
                    data = firstdata[0]; // Assuming one task is returned
                    
                    // Populate form fields
                    form.querySelector('input[name="task_name"]').value = data.task_name;
                    form.querySelector('select[name="task_action"]').value = data.task_action; // Set the selected action
                    form.querySelector('textarea[name="description"]').value = data.description;
                    form.querySelector('input[name="value"]').value = data.value;
                    form.querySelector('input[name="confidence"]').value = data.confidence;
                    form.querySelector('input[name="order"]').value = data.order;
                     // Set the correct radio button for is_loop
                    const isLoopYes = form.querySelector('input[name="is_loop"][value="1"]');
                    const isLoopNo = form.querySelector('input[name="is_loop"][value="0"]');
                    if (data.is_loop === 1) {
                        isLoopYes.checked = true;
                        isLoopNo.checked = false;
                    } else {
                        isLoopYes.checked = false;
                        isLoopNo.checked = true;
                    }

                    // Set the correct radio button for is_stop_task
                    const isStopTaskYes = form.querySelector('input[name="is_stop_task"][value="1"]');
                    const isStopTaskNo = form.querySelector('input[name="is_stop_task"][value="0"]');
                    if (data.is_stop_task === 1) {
                        isStopTaskYes.checked = true;
                        isStopTaskNo.checked = false;
                    } else {
                        isStopTaskYes.checked = false;
                        isStopTaskNo.checked = true;
                    }

                    // Update form title
                    document.querySelector('#process-task-form-container .card-title').textContent = 'Edit Process Task';
                })
                .catch(error => console.error('Error fetching task actions or details:', error));
        }

        function editException(taskId) {
            // Adjust the layout to show the form
            document.getElementById('task-exception-container').classList.remove('col-md-12');
            document.getElementById('task-exception-container').classList.add('col-md-6');
            document.getElementById('task-exception-form-container').style.display = 'block';
            document.getElementById("exception-info-container").style.display = "none";
            // document.getElementById("task-info-container").style.display = "none";
            resetState('exception');
            // Load task actions first
            fetch("{{ route('rpa.action.api') }}")
                .then(response => response.json())
                .then(actions => {
                    let taskActionSelect = document.querySelector('#task-exception-form select[name="task_action"]');

                    // Clear existing options
                    taskActionSelect.innerHTML = '';

                    // Populate dropdown with task actions
                    actions.forEach(action => {
                        let option = document.createElement('option');
                        option.value = action.id; // Assuming `id` is the unique identifier
                        option.textContent = action.function_name; // Assuming `function_name` is the label for the action
                        taskActionSelect.appendChild(option);
                    });

                    // Fetch task details only after task actions are loaded
                    return fetch(`{{ route('rpa.get.exception', ':id') }}`.replace(':id', taskId));
                })
                .then(response => response.json())
                .then(firstdata => {
                    const form = document.getElementById('task-exception-form');
                    form.setAttribute('data-exception-id', taskId); // Store the task ID
                    form.setAttribute('data-mode', 'edit'); // Set mode to 'edit'
                    data = firstdata[0]; // Assuming one task is returned
                    // Populate form fields
                    form.querySelector('input[name="exception_name"]').value = data.exception_name;
                    form.querySelector('select[name="task_action"]').value = data.task_action; // Set the selected action
                    form.querySelector('textarea[name="description"]').value = data.description;
                    form.querySelector('input[name="value"]').value = data.value;
                    form.querySelector('input[name="confidence"]').value = data.confidence;
                    form.querySelector('input[name="order"]').value = data.order;
                    // Set the correct radio button for is_loop
                    const isLoopYes = form.querySelector('input[name="is_loop"][value="1"]');
                    const isLoopNo = form.querySelector('input[name="is_loop"][value="0"]');
                    if (data.is_loop === 1) {
                        isLoopYes.checked = true;
                        isLoopNo.checked = false;
                    } else {
                        isLoopYes.checked = false;
                        isLoopNo.checked = true;
                    }

                    // Set the correct radio button for is_stop_task
                    const isStopTaskYes = form.querySelector('input[name="is_stop_exception"][value="1"]');
                    const isStopTaskNo = form.querySelector('input[name="is_stop_exception"][value="0"]');
                    if (data.is_stop_task === 1) {
                        isStopTaskYes.checked = true;
                        isStopTaskNo.checked = false;
                    } else {
                        isStopTaskYes.checked = false;
                        isStopTaskNo.checked = true;
                    }

                    // Update form title
                    document.querySelector('#task-exception-form-container .card-title').textContent = 'Edit Exception';
                })
                .catch(error => console.error('Error fetching task actions or details:', error));
        }

        function sortTable(){
            // Get the table and tbody elements
            const table = document.getElementById("process-task-table");
            const tbody = document.getElementById("process-task-table-body");

            // Convert the rows to an array for sorting
            const rows = Array.from(tbody.getElementsByTagName("tr"));

            // Sort the rows based on the "Order" column (index 2)
            rows.sort((a, b) => {
                const orderA = parseInt(a.getElementsByTagName("td")[2].textContent, 10);
                const orderB = parseInt(b.getElementsByTagName("td")[2].textContent, 10);
                return orderA - orderB;
            });

            // Remove all rows from the tbody
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            // Append the sorted rows back to the tbody
            rows.forEach(row => tbody.appendChild(row));
        }
        

        // file upload script------------------------
        // no react or anything
        // Separate states for each form 
        let state = {
            exception: { filesArr: [] }, // State for the exception form
            task: { filesArr: [] }       // State for the task form
        };

        // State management
        function updateState(formKey, newState) {
            state[formKey] = { ...state[formKey], ...newState };
            console.log(state);
        }

        // Reset function
        function resetState(formKey) {
            updateState(formKey, { filesArr: [] }); // Reset the filesArr to an empty array
            renderFileList(formKey); // Update the UI to reflect the empty state
        }

        // Event handlers
        $("#uploadException").change(function(e) {
            resetState('exception'); // Reset state for the exception form
            const files = Array.from(this.files);
            updateState('exception', { filesArr: files });
            renderFileList('exception');
        });

        $("#uploadTask").change(function(e) {
            resetState('task'); // Reset state for the task form
            const files = Array.from(this.files);
            updateState('task', { filesArr: files });
            renderFileList('task');
        });

        $(".files").on("click", "li > i", function(e) {
            let key = $(this).parent().attr("key");
            let formKey = $(this).closest('.form-group').find('input[type="file"]').attr('id').replace('upload', '').toLowerCase();
            let curArr = state[formKey].filesArr;
            curArr.splice(key, 1);
            updateState(formKey, { filesArr: curArr });
            renderFileList(formKey);
        });

        // Change this generic form handler
        // $("form").on("submit", function(e) {
        $("#task-exception-form, #process-task-form").on("submit", function(e) {
            e.preventDefault();
            console.log(state);
            // Render file lists for both forms on submit (optional)
            renderFileList('exception');
            renderFileList('task');
        });

        // Render function
        function renderFileList(formKey) {
            const fileList = document.getElementById(`file-list-${formKey}`); // Target specific list
            let fileMap = state[formKey].filesArr.map((file, index) => {
                let suffix = "bytes";
                let size = file.size;
                if (size >= 1024 && size < 1024000) {
                    suffix = "KB";
                    size = Math.round(size / 1024 * 100) / 100;
                } else if (size >= 1024000) {
                    suffix = "MB";
                    size = Math.round(size / 1024000 * 100) / 100;
                }

                return `<li key="${index}">${
                    file.name
                } <span class="file-size">${size} ${suffix}</span><i class="material-icons md-48">delete</i></li>`;
            });

            // Join the fileMap array into a single string and set the innerHTML of the specific list
            fileList.innerHTML = fileMap.join('');
        }
        // file upload script------------------------

        function closeProcessForm(type) {
            // Get the container ID based on the type
            let containerId;
            let tableContainerId;
            
            switch(type) {
                case 'process':
                    containerId = 'process-form-container';
                    tableContainerId = 'process-table-container';
                    break;
                case 'step':
                    containerId = 'process-step-form-container';
                    tableContainerId = 'process-step-container';
                    break;
                case 'task':
                    containerId = 'process-task-form-container';
                    tableContainerId = 'process-task-container';
                    break;
                case 'step-exception':
                    containerId = 'process-step-exception-form-container';
                    tableContainerId = 'process-step-exception-container';
                    break;
                case 'task-exception':
                    containerId = 'task-exception-form-container';
                    tableContainerId = 'task-exception-container';
                    break;
            }

            // Reset the table container back to full width
            if (document.getElementById(tableContainerId)) {
                document.getElementById(tableContainerId).classList.remove('col-md-6');
                document.getElementById(tableContainerId).classList.add('col-md-12');
            }

            // Hide the form container
            if (document.getElementById(containerId)) {
                document.getElementById(containerId).style.display = 'none';
                // Reset the form
                const form = document.querySelector(`#${containerId} form`);
                if (form) {
                    form.reset();
                }
            }
        }

        // Update existing show form functions
        function showAddProcessForm() {
            document.getElementById('process-table-container').classList.remove('col-md-12');
            document.getElementById('process-table-container').classList.add('col-md-6');
            document.getElementById('process-form-container').style.display = 'block';
        }

        function showAddStepForm() {
            document.getElementById('process-step-container').classList.remove('col-md-12');
            document.getElementById('process-step-container').classList.add('col-md-6');
            document.getElementById('process-step-form-container').style.display = 'block';
        }

        function showAddTaskForm() {
            document.getElementById('process-task-container').classList.remove('col-md-12');
            document.getElementById('process-task-container').classList.add('col-md-6');
            document.getElementById('process-task-form-container').style.display = 'block';
        }

        // Add event listeners for existing close buttons
        document.getElementById('remove_process_details')?.addEventListener('click', function() {
            document.getElementById('process-info-container').style.display = 'none';
            document.getElementById('process-table-container').classList.remove('col-md-6');
            document.getElementById('process-table-container').classList.add('col-md-12');
        });

        document.getElementById('remove_step_details')?.addEventListener('click', function() {
            document.getElementById('step-info-container').style.display = 'none';
            document.getElementById('process-step-container').classList.remove('col-md-6');
            document.getElementById('process-step-container').classList.add('col-md-12');
        });
    </script>
</div>
@endsection