// Table Management Module
const ProcessTables = {
    tables: {
        process: null,
        step: null,
        task: null,
        exception: null
    },

    initializeTables: function() {
        // Initialize DataTables
        this.tables.process = new DataTable('#process-table', {
            responsive: true,
            order: [[0, 'asc']]
        });

        this.tables.step = new DataTable('#process-step-table', {
            responsive: true,
            order: [[0, 'asc']]
        });

        this.tables.task = new DataTable('#process-task-table', {
            responsive: true,
            order: [[2, 'asc']] // Order by the "Order" column
        });

        this.tables.exception = new DataTable('#process-exception-table', {
            responsive: true
        });
    },

    sortTable: function(tableId) {
        const table = document.getElementById(tableId);
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.getElementsByTagName("tr"));

        rows.sort((a, b) => {
            const orderA = parseInt(a.getElementsByTagName("td")[2].textContent, 10);
            const orderB = parseInt(b.getElementsByTagName("td")[2].textContent, 10);
            return orderA - orderB;
        });

        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }

        rows.forEach(row => tbody.appendChild(row));
    },

    refreshTable: function(tableType) {
        if (this.tables[tableType]) {
            this.tables[tableType].ajax.reload();
        }
    },

    handleRowClick: function() {
        // Process table row click
        document.querySelector('#process-table tbody').addEventListener('click', function(e) {
            if (!e.target.closest('.btn-icon')) {
                const row = e.target.closest('tr');
                if (row) {
                    this.handleProcessSelection(row);
                }
            }
        }.bind(this));

        // Step table row click
        document.querySelector('#process-step-table tbody').addEventListener('click', function(e) {
            if (!e.target.closest('.btn-icon')) {
                const row = e.target.closest('tr');
                if (row) {
                    this.handleStepSelection(row);
                }
            }
        }.bind(this));
    },

    handleProcessSelection: function(row) {
        const processId = row.getAttribute('data-process-id');
        fetch(`/rpa/get/processes/${processId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const process = data[0];
                    this.updateProcessDetails(process);
                    this.showProcessDetails();
                }
            })
            .catch(error => console.error('Error fetching process details:', error));
    },

    handleStepSelection: function(row) {
        const stepId = row.getAttribute('data-step-id');
        fetch(`/rpa/get/step/${stepId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const step = data[0];
                    this.updateStepDetails(step);
                    this.showStepDetails();
                }
            })
            .catch(error => console.error('Error fetching step details:', error));
    },

    updateProcessDetails: function(process) {
        document.querySelector("#process-info-name span").innerText = process.process_name;
        document.querySelector("#process-info-description span").innerText = process.description;
    },

    updateStepDetails: function(step) {
        document.querySelector("#step-info-name span").innerText = step.step_name;
        document.querySelector("#step-info-description span").innerText = step.description;
    },

    showProcessDetails: function() {
        document.getElementById('process-table-container').classList.remove('col-md-12');
        document.getElementById('process-table-container').classList.add('col-md-6');
        document.getElementById('process-form-container').style.display = 'none';
        document.getElementById("process-info-container").style.display = "block";
    },

    showStepDetails: function() {
        document.getElementById('process-step-container').classList.remove('col-md-12');
        document.getElementById('process-step-container').classList.add('col-md-6');
        document.getElementById('process-step-form-container').style.display = 'none';
        document.getElementById("step-info-container").style.display = "block";
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    ProcessTables.initializeTables();
    ProcessTables.handleRowClick();
});

export default ProcessTables; 