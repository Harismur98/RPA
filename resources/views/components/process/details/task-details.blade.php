<!-- Task Details -->
<div id="task-info-container" class="col-md-6" style="display: none;">
    <div class="card" data-details-type="task">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Task Details</h4>
                <button class="btn btn-link ml-auto details-close-btn">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="details-content">
                <div class="detail-item">
                    <label>Name:</label>
                    <span id="task-info-name"></span>
                </div>
                <div class="detail-item">
                    <label>Description:</label>
                    <span id="task-info-description"></span>
                </div>
                <div class="detail-item">
                    <label>Order:</label>
                    <span id="task-info-order"></span>
                </div>
                <div class="detail-item">
                    <label>Created At:</label>
                    <span id="task-info-created"></span>
                </div>
                <div class="detail-item">
                    <label>Files:</label>
                    <div id="task-info-files" class="file-list"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.file-list {
    margin-top: 0.5rem;
}

.file-list .file-item {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border: 1px solid #eee;
    border-radius: 4px;
    margin-bottom: 0.5rem;
}

.file-list .file-name {
    flex-grow: 1;
}

.file-list .file-size {
    color: #888;
    margin: 0 1rem;
}

.file-list .delete-file {
    color: #ff3d3d;
    background: none;
    border: none;
    padding: 0.25rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.file-list .delete-file:hover {
    color: #ff0000;
}
</style> 