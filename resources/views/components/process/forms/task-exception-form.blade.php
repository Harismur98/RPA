<!-- Task Exception Form -->
<div id="task-exception-form-container" class="col-md-6" style="display: none;">
    <div class="card" data-form-type="task-exception">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Add Task Exception</h4>
                <button class="btn btn-link ml-auto" onclick="ProcessForms.closeProcessForm('task-exception')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="task-exception-form" method="POST" action="{{ route('rpa.process_exception.store') }}">
                @csrf
                <input type="hidden" name="task_id" id="task_exception_task_id">
                <div class="form-group">
                    <label for="task_exception_name">Exception Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="task_exception_name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="task_exception_description">Description</label>
                    <textarea class="form-control" id="task_exception_description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="task_exception_type">Exception Type <span class="text-danger">*</span></label>
                    <select class="form-control" id="task_exception_type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="error">Error</option>
                        <option value="warning">Warning</option>
                        <option value="info">Information</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="task_exception_action">Action <span class="text-danger">*</span></label>
                    <select class="form-control" id="task_exception_action" name="action" required>
                        <option value="">Select Action</option>
                        <option value="retry">Retry</option>
                        <option value="skip">Skip</option>
                        <option value="stop">Stop</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Exception</button>
                    <button type="button" class="btn btn-secondary" onclick="ProcessForms.closeProcessForm('task-exception')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> 