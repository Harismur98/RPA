class ProcessManager {
    constructor() {
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Add Process button handler
        const addButton = document.getElementById('addProcessButton');
        if (addButton) {
            addButton.addEventListener('click', () => this.showAddProcessForm());
        }

        // Process form submission handler
        const form = document.querySelector('#process-form-container form');
        if (form) {
            form.addEventListener('submit', (e) => this.handleProcessFormSubmit(e));
            console.log('Form submission listener added'); // Debug log
        } else {
            console.error('Process form not found'); // Debug log
        }
    }

    showAddProcessForm() {
        const tableContainer = document.getElementById('process-table-container');
        const formContainer = document.getElementById('process-form-container');
        const infoContainer = document.getElementById('process-info-container');
        
        // Adjust layout
        tableContainer.classList.remove('col-md-12');
        tableContainer.classList.add('col-md-6');

        // Reset and prepare form
        const form = formContainer.querySelector('form');
        form.reset();
        form.action = '/rpa/process/store';
        form.method = 'POST';

        // Remove any existing method override
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();

        // Update UI
        formContainer.querySelector('.card-title').textContent = 'Add Process';
        infoContainer.style.display = 'none';
        formContainer.style.display = 'block';
    }

    async handleProcessFormSubmit(event) {
        event.preventDefault();
        console.log('Form submission triggered'); // Debug log

        const form = event.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            console.log('Response status:', response.status); // Debug log

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response data:', data); // Debug log

            if (data.success) {
                // Add new row to table
                this.addProcessToTable(data.process);
                
                // Reset form and UI
                this.resetFormAndUI(form);
            } else {
                alert(data.message || 'Failed to save process');
            }
        } catch (error) {
            console.error('Error saving process:', error);
            alert('Error saving process. Please try again.');
        }
    }

    addProcessToTable(process) {
        const tableBody = document.querySelector('#vm-table tbody');
        const newRow = `
            <tr id="process-row-${process.id}">
                <td>${process.process_name}</td>
                <td>${process.description}</td>
                <td>
                    <button class="btn btn-link btn-primary" onclick="editProcess(${process.id}, '${process.process_name}', '${process.description}', '${process.edit_route}')">Edit</button>
                    <button class="btn btn-link btn-danger" onclick="deleteItem(${process.id}, 'process')">Delete</button>
                    <button class="btn btn-link btn-info" data-process-id="${process.id}" onclick="toggleProcessView(this)">
                        <i class="fa fa-eye"></i> View Step
                    </button>
                    <button class="btn btn-link btn-info" data-process-id="${process.id}" onclick="showProcessDetails(this)">
                        View Process
                    </button>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', newRow);
    }

    resetFormAndUI(form) {
        form.reset();
        const formContainer = document.getElementById('process-form-container');
        const tableContainer = document.getElementById('process-table-container');
        
        formContainer.style.display = 'none';
        tableContainer.classList.remove('col-md-6');
        tableContainer.classList.add('col-md-12');
    }
}

export default ProcessManager; 