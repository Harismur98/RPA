<!-- Task Form -->
<div id="process-task-form-container" class="col-md-6" style="display: none;">
    <div class="card" data-form-type="task">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Add Task</h4>
                <button class="btn btn-link ml-auto" onclick="ProcessForms.closeProcessForm('task')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="process-task-form" method="POST" action="{{ route('rpa.process_task.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="step_id" id="task_step_id">
                <div class="form-group">
                    <label for="task_name">Task Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="task_name" name="task_name" required>
                </div>
                <div class="form-group">
                    <label for="task_description">Description</label>
                    <textarea class="form-control" id="task_description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="task_order">Order <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="task_order" name="order" required min="1">
                </div>
                <div class="form-group">
                    <label for="condition_type">Condition Type</label>
                    <select class="form-control" id="condition_type" name="condition_type">
                        <option value="">Select Condition Type</option>
                        @foreach(\App\Enums\ConditionType::cases() as $type)
                            <option value="{{ $type->value }}">{{ ucwords(str_replace('_', ' ', $type->value)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Files</label>
                    <div class="upload-container">
                        <div id="drop-zone" class="dropzone">
                            <div class="dz-message">
                                Drop files here or click to upload
                            </div>
                        </div>
                        <div id="file-list" class="file-list mt-3"></div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Task</button>
                    <button type="button" class="btn btn-secondary" onclick="ProcessForms.closeProcessForm('task')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.dropzone {
    border: 2px dashed #ddd;
    border-radius: 4px;
    padding: 20px;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.dropzone.drag-over {
    background: #e9ecef;
    border-color: #1572E8;
}

.dz-message {
    color: #6c757d;
    font-size: 16px;
}

.upload-container {
    margin-bottom: 1rem;
}

.progress-bar {
    height: 4px;
    background: #1572E8;
    margin-top: 1rem;
    width: 0;
    transition: width 0.3s ease;
}
</style> 