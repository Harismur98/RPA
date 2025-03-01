// Form Management Module
const ProcessForms = {
    // Form close functionality
    closeProcessForm: function(type) {
        const config = {
            process: {
                formId: 'process-form-container',
                tableId: 'process-table-container'
            },
            step: {
                formId: 'process-step-form-container',
                tableId: 'process-step-container'
            },
            task: {
                formId: 'process-task-form-container',
                tableId: 'process-task-container'
            },
            'step-exception': {
                formId: 'process-step-exception-form-container',
                tableId: 'process-step-exception-container'
            },
            'task-exception': {
                formId: 'task-exception-form-container',
                tableId: 'task-exception-container'
            }
        };

        const { formId, tableId } = config[type];
        
        // Reset table width
        if (document.getElementById(tableId)) {
            document.getElementById(tableId).classList.remove('col-md-6');
            document.getElementById(tableId).classList.add('col-md-12');
        }

        // Hide and reset form
        if (document.getElementById(formId)) {
            document.getElementById(formId).style.display = 'none';
            const form = document.querySelector(`#${formId} form`);
            if (form) form.reset();
        }
    },

    // Show form functions
    showAddProcessForm: function() {
        document.getElementById('process-table-container').classList.remove('col-md-12');
        document.getElementById('process-table-container').classList.add('col-md-6');
        document.getElementById('process-form-container').style.display = 'block';
    },

    showAddStepForm: function() {
        document.getElementById('process-step-container').classList.remove('col-md-12');
        document.getElementById('process-step-container').classList.add('col-md-6');
        document.getElementById('process-step-form-container').style.display = 'block';
    },

    showAddTaskForm: function() {
        document.getElementById('process-task-container').classList.remove('col-md-12');
        document.getElementById('process-task-container').classList.add('col-md-6');
        document.getElementById('process-task-form-container').style.display = 'block';
    },

    // Form submission handlers
    initializeFormHandlers: function() {
        // Process form submission
        document.querySelector('#process-form')?.addEventListener('submit', this.handleProcessSubmit);
        
        // Step form submission
        document.querySelector('#process-step-form')?.addEventListener('submit', this.handleStepSubmit);
        
        // Task form submission
        document.querySelector('#process-task-form')?.addEventListener('submit', this.handleTaskSubmit);
        
        // Exception forms submission
        document.querySelector('#task-exception-form')?.addEventListener('submit', this.handleExceptionSubmit);
        document.querySelector('#process-step-exception-form')?.addEventListener('submit', this.handleStepExceptionSubmit);
    },

    // Initialize all close buttons
    initializeCloseButtons: function() {
        // Add click handlers for all close buttons
        document.querySelectorAll('.close').forEach(button => {
            button.addEventListener('click', (e) => {
                const type = e.target.closest('.card').dataset.formType;
                this.closeProcessForm(type);
            });
        });
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    ProcessForms.initializeFormHandlers();
    ProcessForms.initializeCloseButtons();
});

// Export for use in other modules
export default ProcessForms; 