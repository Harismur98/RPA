<!-- Task Table -->
<div id="process-task-container" class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Task List</h4>
                <button class="btn btn-primary btn-round ml-auto" onclick="ProcessForms.showAddTaskForm()">
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
                            <th>Name</th>
                            <th>Description</th>
                            <th>Order</th>
                            <th>Created At</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks ?? [] as $task)
                        <tr data-task-id="{{ $task->id }}">
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->order }}</td>
                            <td>{{ $task->created_at }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-icon btn-primary btn-round btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Edit Task"
                                            onclick="ProcessForms.showEditTaskForm({{ $task->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger btn-round btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Delete Task"
                                            onclick="ProcessForms.deleteTask({{ $task->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 