// Import modules
import ProcessForms from './forms';
import ProcessTables from './tables';
import ProcessDetails from './details';
import FileUpload from './file-upload';

// Main Process Management Module
const ProcessManager = {
    init: function() {
        // Initialize all modules
        this.initializeModules();
        
        // Initialize tooltips and popovers
        this.initializeBootstrapComponents();
        
        // Initialize tab handling
        this.initializeTabHandling();
        
        // Initialize global event listeners
        this.initializeEventListeners();
    },

    initializeModules: function() {
        // Each module has its own initialization in its DOMContentLoaded event
        // but we can also manually initialize them here if needed
        ProcessForms.initializeFormHandlers();
        ProcessForms.initializeCloseButtons();
        
        ProcessTables.initializeTables();
        ProcessTables.handleRowClick();
        
        ProcessDetails.initializeCloseButtons();
        
        FileUpload.init();
    },

    initializeBootstrapComponents: function() {
        // Initialize all tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize all popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    },

    initializeTabHandling: function() {
        // Handle tab switching
        const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabLinks.forEach(tab => {
            tab.addEventListener('shown.bs.tab', (event) => {
                const targetId = event.target.getAttribute('href');
                this.handleTabChange(targetId);
            });
        });
    },

    handleTabChange: function(targetId) {
        // Close any open forms or details panels when switching tabs
        switch(targetId) {
            case '#process-content':
                ProcessForms.closeProcessForm('process');
                ProcessDetails.closeDetails('process');
                break;
            case '#step-content':
                ProcessForms.closeProcessForm('step');
                ProcessDetails.closeDetails('step');
                break;
            case '#task-content':
                ProcessForms.closeProcessForm('task');
                ProcessDetails.closeDetails('task');
                break;
        }
    },

    initializeEventListeners: function() {
        // Global error handler
        window.addEventListener('error', this.handleError.bind(this));

        // Handle browser back/forward
        window.addEventListener('popstate', this.handleNavigation.bind(this));
    },

    handleError: function(error) {
        console.error('Application error:', error);
        // Show error notification to user
        this.showNotification('An error occurred. Please try again.', 'error');
    },

    handleNavigation: function(event) {
        // Handle browser navigation (back/forward)
        const state = event.state;
        if (state && state.tab) {
            // Activate the correct tab
            const tab = document.querySelector(`[href="#${state.tab}"]`);
            if (tab) {
                bootstrap.Tab.getOrCreateInstance(tab).show();
            }
        }
    },

    showNotification: function(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        // Add to notification container
        const container = document.querySelector('.notification-container') || document.body;
        container.appendChild(alertDiv);

        // Auto dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    ProcessManager.init();
});

export default ProcessManager; 