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
            <div class="row">
                <!-- The process table column -->
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
                                <table id="vm-table" class="display table table-striped table-hover">
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
                                            <tr>
                                                <td>{{ $p->process_name }}</td>
                                                <td>{{ $p->description }}</td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="{{ route('rpa.process.edit', $p->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit Task">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('rpa.process.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Remove">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                        <button class="btn btn-link btn-info" data-process-id="{{ $p->id }}" onclick="toggleProcessView(this)">
                                                            <i class="fa fa-eye"></i> View
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

                <!-- The process step table, hidden initially -->
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

                <!-- The process step table, hidden initially -->
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
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="value">Value</label>
                                    <input type="text" class="form-control" name="value" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confidence">Confidence</label>
                                            <input type="text" class="form-control" name="confidence" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order">Order</label>
                                            <input type="text" class="form-control" name="order" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_loop">Is Loop?</label>
                                            <input type="text" class="form-control" name="is_loop" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_stop_task">Is Stop Task?</label>
                                            <input type="text" class="form-control" name="is_stop_task" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image1">Upload Image 1</label>
                                            <input type="file" class="form-control" name="file1" accept="image/*" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image2">Upload Image 2</label>
                                            <input type="file" class="form-control" name="file2" accept="image/*" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image3">Upload Image 3</label>
                                            <input type="file" class="form-control" name="file3" accept="image/*" required>
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
        </div>
    </div>

    @include('components.footer')

    <script>
        document.getElementById('addProcessButton').addEventListener('click', function() {
            // Change the table's grid from col-md-12 to col-md-6
            document.getElementById('process-table-container').classList.remove('col-md-12');
            document.getElementById('process-table-container').classList.add('col-md-6');

            // Show the form container
            document.getElementById('process-form-container').style.display = 'block';
        });

        function toggleProcessView(button) {
            let processTableContainer = document.getElementById('process-table-container');
            let processStepContainer = document.getElementById('process-step-container');

            if (processTableContainer.classList.contains('collapsed')) {
                processTableContainer.classList.remove('collapsed');
                processTableContainer.classList.add('col-md-12');
                processStepContainer.style.display = 'none';
            } else {
                processTableContainer.classList.add('collapsed');
                processTableContainer.classList.remove('col-md-12');
                // processTableContainer.style.display = 'none';
                processStepContainer.style.display = 'block';

                let processId = button.getAttribute('data-process-id');
                document.getElementById('process-id').value = processId;
                loadProcessSteps(processId);
            }

            
        }

        function toggleStepView(button) {
            let processTableContainer = document.getElementById('process-table-container');
            let processStepContainer = document.getElementById('process-step-container');
            let processTaskContainer = document.getElementById('process-task-container');

            if (processStepContainer.classList.contains('collapsed')) {
                processStepContainer.classList.remove('collapsed');
                processStepContainer.classList.add('col-md-12');
                processTaskContainer.style.display = 'none';
            } else {
                processStepContainer.classList.add('collapsed');
                processStepContainer.classList.remove('col-md-12');
                processTableContainer.style.display = 'none';
                processTaskContainer.style.display = 'block';

                let stepId = button.getAttribute('data-step-id');
                document.getElementById('step-id').value = stepId;
                loadProcessTasks(stepId);
            }
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
                                <tr>
                                    <td>${step.Step_name}</td>
                                    <td>${step.description}</td>
                                    <td>
                                        <!-- Action buttons for process steps -->
                                        <button class="btn btn-link btn-primary" onclick="editStep(${step.id})">Edit</button>
                                        <button class="btn btn-link btn-danger" onclick="deleteStep(${step.id})">Delete</button>
                                        <button class="btn btn-link btn-info" data-step-id="${step.id}" onclick="toggleStepView(this)">
                                            <i class="fa fa-eye"></i> View
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
                                <tr>
                                    <td>${task.task_name}</td>
                                    <td>${task.description}</td>
                                    <td>
                                        <!-- Action buttons for process steps -->
                                        <button class="btn btn-link btn-primary" onclick="editStep(${task.id})">Edit</button>
                                        <button class="btn btn-link btn-danger" onclick="deleteStep(${task.id})">Delete</button>
                                        <button class="btn btn-link btn-info" data-process-id="${task.id}" onclick="toggleProcessView(this)">
                                            <i class="fa fa-eye"></i> View
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

        function editStep(stepId) {
            console.log("Edit step with ID:", stepId);
        }

        function deleteStep(stepId) {
            console.log("Delete step with ID:", stepId);
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
                let processTaskTableBody = document.getElementById('process-task-table-body');
                let row = `
                    <tr>
                        <td>${data.task_name}</td>
                        <td>${data.description}</td>
                        <td>
                            <button class="btn btn-link btn-primary" onclick="editTask(${data.id})">Edit</button>
                            <button class="btn btn-link btn-danger" onclick="deleteTask(${data.id})">Delete</button>
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

    </script>
</div>
@endsection