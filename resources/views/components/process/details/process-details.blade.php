<!-- Process Details -->
<div id="process-info-container" class="col-md-6" style="display: none;">
    <div class="card" data-details-type="process">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Process Details</h4>
                <button class="btn btn-link ml-auto details-close-btn">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="details-content">
                <div class="detail-item">
                    <label>Name:</label>
                    <span id="process-info-name"></span>
                </div>
                <div class="detail-item">
                    <label>Description:</label>
                    <span id="process-info-description"></span>
                </div>
                <div class="detail-item">
                    <label>Created At:</label>
                    <span id="process-info-created"></span>
                </div>
                <div class="detail-item">
                    <label>Updated At:</label>
                    <span id="process-info-updated"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.detail-item {
    margin-bottom: 1rem;
}

.detail-item label {
    font-weight: bold;
    display: block;
    margin-bottom: 0.25rem;
    color: #1a2035;
}

.detail-item span {
    color: #555;
}

.details-close-btn {
    padding: 0;
    color: #888;
    transition: color 0.3s ease;
}

.details-close-btn:hover {
    color: #ff3d3d;
}
</style> 