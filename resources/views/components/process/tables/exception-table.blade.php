<!-- Exception Table -->
<div id="process-exception-container" class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Exception List</h4>
                <div class="ml-auto">
                    <button class="btn btn-primary btn-round" onclick="ProcessForms.showAddStepExceptionForm()">
                        <i class="fa fa-plus"></i>
                        Add Step Exception
                    </button>
                    <button class="btn btn-primary btn-round" onclick="ProcessForms.showAddTaskExceptionForm()">
                        <i class="fa fa-plus"></i>
                        Add Task Exception
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="process-exception-table" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exceptions ?? [] as $exception)
                        <tr data-exception-id="{{ $exception->id }}" data-exception-type="{{ $exception->type }}">
                            <td>{{ ucfirst($exception->type) }}</td>
                            <td>{{ $exception->name }}</td>
                            <td>{{ $exception->description }}</td>
                            <td>{{ $exception->created_at }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-icon btn-primary btn-round btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Edit Exception"
                                            onclick="ProcessForms.showEditExceptionForm({{ $exception->id }}, '{{ $exception->type }}')">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger btn-round btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Delete Exception"
                                            onclick="ProcessForms.deleteException({{ $exception->id }}, '{{ $exception->type }}')">
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