// Details Panel Management Module
const ProcessDetails = {
    // Close details panel functionality
    closeDetails: function(type) {
        const config = {
            process: {
                detailsId: 'process-info-container',
                tableId: 'process-table-container'
            },
            step: {
                detailsId: 'step-info-container',
                tableId: 'process-step-container'
            },
            task: {
                detailsId: 'task-info-container',
                tableId: 'process-task-container'
            }
        };

        const { detailsId, tableId } = config[type];
        
        // Reset table width
        if (document.getElementById(tableId)) {
            document.getElementById(tableId).classList.remove('col-md-6');
            document.getElementById(tableId).classList.add('col-md-12');
        }

        // Hide details panel
        if (document.getElementById(detailsId)) {
            document.getElementById(detailsId).style.display = 'none';
        }
    },

    // Load and display details
    loadProcessDetails: function(processId) {
        fetch(`/rpa/get/processes/${processId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.displayProcessDetails(data.process);
                }
            })
            .catch(error => console.error('Error loading process details:', error));
    },

    loadStepDetails: function(stepId) {
        fetch(`/rpa/get/step/${stepId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.displayStepDetails(data.step);
                }
            })
            .catch(error => console.error('Error loading step details:', error));
    },

    loadTaskDetails: function(taskId) {
        fetch(`/rpa/get/task/${taskId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.displayTaskDetails(data.task);
                }
            })
            .catch(error => console.error('Error loading task details:', error));
    },

    // Display details in panels
    displayProcessDetails: function(process) {
        const container = document.getElementById('process-info-container');
        if (container) {
            document.getElementById('process-info-name').textContent = process.process_name;
            document.getElementById('process-info-description').textContent = process.description;
            document.getElementById('process-info-created').textContent = new Date(process.created_at).toLocaleString();
            document.getElementById('process-info-updated').textContent = new Date(process.updated_at).toLocaleString();
            
            container.style.display = 'block';
            this.adjustTableWidth('process-table-container');
        }
    },

    displayStepDetails: function(step) {
        const container = document.getElementById('step-info-container');
        if (container) {
            document.getElementById('step-info-name').textContent = step.step_name;
            document.getElementById('step-info-description').textContent = step.description;
            document.getElementById('step-info-order').textContent = step.order;
            document.getElementById('step-info-created').textContent = new Date(step.created_at).toLocaleString();
            
            container.style.display = 'block';
            this.adjustTableWidth('process-step-container');
        }
    },

    displayTaskDetails: function(task) {
        const container = document.getElementById('task-info-container');
        if (container) {
            document.getElementById('task-info-name').textContent = task.task_name;
            document.getElementById('task-info-description').textContent = task.description;
            document.getElementById('task-info-order').textContent = task.order;
            document.getElementById('task-info-created').textContent = new Date(task.created_at).toLocaleString();
            
            container.style.display = 'block';
            this.adjustTableWidth('process-task-container');
        }
    },

    // Helper function to adjust table width when showing details
    adjustTableWidth: function(tableContainerId) {
        const container = document.getElementById(tableContainerId);
        if (container) {
            container.classList.remove('col-md-12');
            container.classList.add('col-md-6');
        }
    },

    // Initialize close buttons
    initializeCloseButtons: function() {
        document.querySelectorAll('.details-close-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const type = e.target.closest('.card').dataset.detailsType;
                this.closeDetails(type);
            });
        });
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    ProcessDetails.initializeCloseButtons();
});

export default ProcessDetails; 