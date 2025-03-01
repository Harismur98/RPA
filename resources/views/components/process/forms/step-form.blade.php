<!-- Step Form -->
<div id="process-step-form-container" class="col-md-6" style="display: none;">
    <div class="card" data-form-type="step">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Add Step</h4>
                <button class="btn btn-link ml-auto" onclick="ProcessForms.closeProcessForm('step')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="process-step-form" method="POST" action="{{ route('rpa.process_step.store') }}">
                @csrf
                <input type="hidden" name="process_id" id="step_process_id">
                <div class="form-group">
                    <label for="step_name">Step Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="step_name" name="step_name" required>
                </div>
                <div class="form-group">
                    <label for="step_description">Description</label>
                    <textarea class="form-control" id="step_description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="step_order">Order <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="step_order" name="order" required min="1">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Step</button>
                    <button type="button" class="btn btn-secondary" onclick="ProcessForms.closeProcessForm('step')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div> 