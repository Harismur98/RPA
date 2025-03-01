<!-- Process Table -->
<div id="process-table-container" class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Process List</h4>
                <button class="btn btn-primary btn-round ml-auto" onclick="ProcessForms.showAddProcessForm()">
                    <i class="fa fa-plus"></i>
                    Add Process
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="process-table" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($processes ?? [] as $process)
                        <tr data-process-id="{{ $process->id }}">
                            <td>{{ $process->process_name }}</td>
                            <td>{{ $process->description }}</td>
                            <td>{{ $process->created_at }}</td>
                            <td>{{ $process->updated_at }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-icon btn-primary btn-round btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Edit Process"
                                            onclick="ProcessForms.showEditProcessForm({{ $process->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger btn-round btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Delete Process"
                                            onclick="ProcessForms.deleteProcess({{ $process->id }})">
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