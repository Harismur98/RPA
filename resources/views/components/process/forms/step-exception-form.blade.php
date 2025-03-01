<!-- Step Exception Form -->
<div id="process-step-exception-form-container" class="col-md-6" style="display: none;">
    <div class="card" data-form-type="step-exception">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Add Step Exception</h4>
                <button class="btn btn-link ml-auto" onclick="ProcessForms.closeProcessForm('step-exception')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="step-exception-form" method="POST" action="{{ route('rpa.process_step_exception.store') }}">
                @csrf
                <input type="hidden" name="step_id" id="exception_step_id">
                <div class="form-group">
                    <label for="exception_name">Exception Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="exception_name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="exception_description">Description</label>
                    <textarea class="form-control" id="exception_description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="exception_type">Exception Type <span class="text-danger">*</span></label>
                    <select class="form-control" id="exception_type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="error">Error</option>
                        <option value="warning">Warning</option>
                        <option value="info">Information</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exception_action">Action <span class="text-danger">*</span></label>
                    <select class="form-control" id="exception_action" name="action" required>
                        <option value="">Select Action</option>
                        <option value="retry">Retry</option>
                        <option value="skip">Skip</option>
                        <option value="stop">Stop</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Exception</button>
                    <button type="button" class="btn btn-secondary" onclick="ProcessForms.closeProcessForm('step-exception')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> 