<!-- Process Form -->
<div id="process-form-container" class="col-md-6" style="display: none;">
    <div class="card" data-form-type="process">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Add Process</h4>
                <button class="btn btn-link ml-auto" onclick="ProcessForms.closeProcessForm('process')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="process-form" method="POST" action="{{ route('rpa.process.store') }}">
                @csrf
                <div class="form-group">
                    <label for="process_name">Process Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="process_name" name="process_name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Process</button>
                    <button type="button" class="btn btn-secondary" onclick="ProcessForms.closeProcessForm('process')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1a2035;
}

.form-control {
    border: 1px solid #ebedf2;
    padding: 0.6rem 1rem;
    height: auto;
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
}

.form-control:focus {
    border-color: #1572E8;
    box-shadow: 0 0 0 0.2rem rgba(21, 114, 232, 0.25);
}

textarea.form-control {
    min-height: 100px;
}

.btn {
    padding: 0.65rem 1.4rem;
    font-size: 14px;
    opacity: 1;
}

.btn:hover {
    opacity: 0.9;
}

.card-header .btn-link {
    padding: 0;
    color: #888;
    transition: color 0.3s ease;
}

.card-header .btn-link:hover {
    color: #ff3d3d;
}
</style> 