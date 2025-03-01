// File Upload Management Module
const FileUpload = {
    // Configuration for file upload
    config: {
        allowedTypes: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'],
        maxSize: 5 * 1024 * 1024, // 5MB
        uploadEndpoint: '/rpa/upload'
    },

    // Initialize file upload listeners
    init: function() {
        this.initializeDropZone();
        this.initializeFileInput();
    },

    // Initialize dropzone functionality
    initializeDropZone: function() {
        const dropZone = document.getElementById('drop-zone');
        if (!dropZone) return;

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, this.preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('drag-over');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            this.handleFiles(files);
        });
    },

    // Initialize file input functionality
    initializeFileInput: function() {
        const fileInput = document.querySelector('input[type="file"]');
        if (!fileInput) return;

        fileInput.addEventListener('change', (e) => {
            this.handleFiles(e.target.files);
        });
    },

    // Handle file validation and upload
    handleFiles: function(files) {
        Array.from(files).forEach(file => {
            if (this.validateFile(file)) {
                this.uploadFile(file);
            }
        });
    },

    // Validate file type and size
    validateFile: function(file) {
        if (!this.config.allowedTypes.includes(file.type)) {
            this.showError('Invalid file type. Please upload Excel files only.');
            return false;
        }

        if (file.size > this.config.maxSize) {
            this.showError('File is too large. Maximum size is 5MB.');
            return false;
        }

        return true;
    },

    // Upload file to server
    uploadFile: function(file) {
        const formData = new FormData();
        formData.append('file', file);

        // Show upload progress
        const progressBar = this.createProgressBar();

        fetch(this.config.uploadEndpoint, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.showSuccess('File uploaded successfully');
                this.updateFileList(data.file);
            } else {
                this.showError(data.message || 'Upload failed');
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            this.showError('An error occurred during upload');
        })
        .finally(() => {
            progressBar.remove();
        });
    },

    // Create and show progress bar
    createProgressBar: function() {
        const progressBar = document.createElement('div');
        progressBar.className = 'progress-bar';
        document.querySelector('.upload-container').appendChild(progressBar);
        return progressBar;
    },

    // Update file list in UI
    updateFileList: function(file) {
        const fileList = document.getElementById('file-list');
        if (!fileList) return;

        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';
        fileItem.innerHTML = `
            <span class="file-name">${file.name}</span>
            <span class="file-size">${this.formatFileSize(file.size)}</span>
            <button class="delete-file" data-file-id="${file.id}">Delete</button>
        `;

        fileList.appendChild(fileItem);

        // Add delete handler
        fileItem.querySelector('.delete-file').addEventListener('click', () => {
            this.deleteFile(file.id, fileItem);
        });
    },

    // Delete file
    deleteFile: function(fileId, fileItem) {
        fetch(`/rpa/delete-file/${fileId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fileItem.remove();
                this.showSuccess('File deleted successfully');
            } else {
                this.showError(data.message || 'Delete failed');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            this.showError('An error occurred while deleting the file');
        });
    },

    // Helper function to format file size
    formatFileSize: function(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },

    // Show success message
    showSuccess: function(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success';
        alert.textContent = message;
        document.querySelector('.upload-container').appendChild(alert);
        setTimeout(() => alert.remove(), 3000);
    },

    // Show error message
    showError: function(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger';
        alert.textContent = message;
        document.querySelector('.upload-container').appendChild(alert);
        setTimeout(() => alert.remove(), 3000);
    },

    // Prevent default drag and drop behavior
    preventDefaults: function(e) {
        e.preventDefault();
        e.stopPropagation();
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    FileUpload.init();
});

export default FileUpload; 