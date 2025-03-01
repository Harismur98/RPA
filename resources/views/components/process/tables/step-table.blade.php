<!-- Step Table -->
<div id="process-step-container" class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Step List</h4>
                <button class="btn btn-primary btn-round ml-auto" onclick="ProcessForms.showAddStepForm()">
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
                            <th>Name</th>
                            <th>Description</th>
                            <th>Order</th>
                            <th>Created At</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($steps ?? [] as $step)
                        <tr data-step-id="{{ $step->id }}">
                            <td>{{ $step->step_name }}</td>
                            <td>{{ $step->description }}</td>
                            <td>{{ $step->order }}</td>
                            <td>{{ $step->created_at }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-icon btn-primary btn-round btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Edit Step"
                                            onclick="ProcessForms.showEditStepForm({{ $step->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger btn-round btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Delete Step"
                                            onclick="ProcessForms.deleteStep({{ $step->id }})">
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