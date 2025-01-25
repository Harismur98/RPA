@extends('layout.app')

@section('content')
<div class="main-panel">
    @include('components.navbarHeader')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h3 class="fw-bold mb-3">Panels</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Base</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Panels</a>
                    </li>
                </ul>
                <div class="ms-auto">
                    <form id="addJobForm" method="POST">
                        @csrf
                        <input type="hidden" id="selectedJobId" name="id">
                        <button type="button" id="addJobButton" class="btn btn-primary">Add Job</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <!-- The table column -->
                <div class="col-md-12" id="template-table-container">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Job Template</h4>
                                <button
                                    class="btn btn-primary btn-round ms-auto"
                                    id="addTemplateButton"
                                >
                                    <i class="fa fa-plus"></i>
                                    Add Template
                                </button>
                            </div>
                        </div>
                        {{-- <p><button id="button">Row count</button></p> --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="vm-table" class="display table table-hover">
                            <thead>
                              <tr>
                                <th>Template Name</th>
                                <th>Process</th>
                                <th>VM</th>
                                <th style="width: 10%">Action</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Template Name</th>
                                <th>Process</th>
                                <th>VM</th>
                                <th>Action</th>
                              </tr>
                            </tfoot>
                            <tbody>
                                @foreach($template as $jobTemplate)
                                    <tr data-id="{{ $jobTemplate->id }}" id="template-row-{{$jobTemplate->id}}">
                                        <td>{{ $jobTemplate->name }}</td>
                                        <td>{{ $jobTemplate->process ? $jobTemplate->process->process_name : 'No process' }}</td>
                                        <td>{{ $jobTemplate->vm ? $jobTemplate->vm->name : 'No VM' }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button 
                                                    class="btn btn-link btn-primary btn-lg edit-template-button" 
                                                    data-id="{{ $jobTemplate->id }}" 
                                                    data-name="{{ $jobTemplate->name }}" 
                                                    data-description="{{ $jobTemplate->description }}" 
                                                    data-vm-name="{{ $jobTemplate->vm ? $jobTemplate->vm->name : '' }}" 
                                                    data-process-id="{{ $jobTemplate->process_id }}"
                                                    title="Edit"
                                                >
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                    <button type="submit" class="btn btn-link btn-danger" onclick="deleteItem({{ $jobTemplate->id }},'template')" data-bs-toggle="tooltip" title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>                                
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                    <div class="col-md-6" id="add-template-form-container" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New Template</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('rpa.template.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="processSelectAdd">Select Process</label>
                                        <select class="form-select" name="process_id" id="processSelectAdd" required>
                                            <option value="" disabled selected>Loading processes...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="vmSelectAdd">Select VM</label>
                                        <select class="form-select" name="vm_id" id="vmSelectAdd" required>
                                            <option value="" disabled selected>Loading vm...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save Process</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" id="edit-template-form-container" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Template</h4>
                            </div>
                            <div class="card-body">
                                <form id="editTemplateForm" action="{{ route('rpa.template.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="templateId">
                                    <div class="form-group">
                                        <label for="templateName">Name</label>
                                        <input type="text" class="form-control" name="name" id="templateName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="templateDescription">Description</label>
                                        <textarea class="form-control" name="description" id="templateDescription" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="processSelectEdit">Select Process</label>
                                        <select class="form-select" name="process_id" id="processSelectEdit" required>
                                            <option value="" disabled selected>Loading processes...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="vmSelectEdit">VM Name</label>
                                        <select class="form-select" name="vm_id" id="vmSelectEdit" required>
                                            <option value="" disabled selected>Loading vm...</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>

                

            </div>
        </div>
    </div>			

    @include('components.footer')
    <script>
        const table = new DataTable('#vm-table');
        let selectedJobId = null;
        $('#vm-table tbody').on('click', 'tr', function() {
            // Toggle selected class
            $(this).toggleClass('selected');
            
            // Get the job template ID from the data attribute
            selectedJobId = $(this).data('id');
            
            // Clear selection for other rows
            $('#vm-table tbody tr').not(this).removeClass('selected');
        });

        $('#addJobButton').on('click', function() {
            if (selectedJobId) {
                // Set the hidden input with the selected job template ID
                $('#selectedJobId').val(selectedJobId);
                
                // Set the form action URL with the selected job template ID
                const baseUrl = "{{ url('rpa/job/add-job') }}";
                $('#addJobForm').attr('action', `${baseUrl}/${selectedJobId}`);
                
                // Submit the form
                $('#addJobForm').submit();
            } else {
                alert('Please select a job template.');
            }
        });
        
        // document.querySelector('#button').addEventListener('click', function () {
        //     alert(table.rows('.selected').data().length + ' row(s) selected');
        // });


        document.getElementById('addTemplateButton').addEventListener('click', function() {
            // Change the table's grid from col-md-12 to col-md-6
            document.getElementById('template-table-container').classList.remove('col-md-12');
            document.getElementById('template-table-container').classList.add('col-md-6');

            // Show the form container
            document.getElementById('add-template-form-container').style.display = 'block';
            loadDropdowns();
        });

        function deleteItem(itemId, type) {
            const confirmMessage = `Are you sure you want to delete this ${type}?`;
            const routeUrl = {
                template: "{{ route('rpa.template.destroy', '') }}/",

            };

            if (confirm(confirmMessage)) {
                fetch(routeUrl[type] + itemId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the deleted item row from the table
                        document.getElementById(`${type}-row-${itemId}`).remove();


                        //kena remove table yg terbukak


                        
                        console.log(`${type.charAt(0).toUpperCase() + type.slice(1)} deleted successfully.`);
                    } else {
                        console.error(`Failed to delete ${type}:`, data.message);
                    }
                })
                .catch(error => console.error(`Error deleting ${type}:`, error));
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-template-button');
            loadDropdowns('edit');
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Extract data from the clicked row
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description');
                    const vm_name = this.getAttribute('data-vm-name');
                    const processId = this.getAttribute('data-process-id');

                    // Populate the form fields
                    document.getElementById('templateId').value = id;
                    document.getElementById('templateName').value = name;
                    document.getElementById('templateDescription').value = description;
                    document.getElementById('vmSelectEdit').value = vm_name;

                    const processSelect = document.getElementById('processSelectEdit');
                    [...processSelect.options].forEach(option => {
                        option.selected = option.value == processId;
                    });

                    // Adjust layout
                    document.getElementById('template-table-container').classList.remove('col-md-12');
                    document.getElementById('template-table-container').classList.add('col-md-6');
                    document.getElementById('edit-template-form-container').style.display = 'block';
                });
            });
        });

        function loadDropdowns(type = 'add') {
            // Adjusted to pass the form type
            const processSelect = (type === 'add') ? $('#processSelectAdd') : $('#processSelectEdit');
            const vmSelect = (type === 'add') ? $('#vmSelectAdd') : $('#vmSelectEdit');

            // Load processes and VMs for both cases
            $.ajax({
                url: '{{ route("rpa.get.process") }}',
                method: 'GET',
                success: function (data) {
                    processSelect.empty();
                    processSelect.append('<option value="" disabled selected>Select a process</option>');
                    data.forEach(process => {
                        processSelect.append(`<option value="${process.id}">${process.process_name}</option>`);
                    });
                },
                error: function () {
                    alert('Failed to load processes. Please try again.');
                }
            });

            $.ajax({
                url: '{{ route("get.vm") }}',
                method: 'GET',
                success: function (data) {
                    vmSelect.empty();
                    vmSelect.append('<option value="" disabled selected>Select a VM</option>');
                    data.forEach(vm => {
                        vmSelect.append(`<option value="${vm.id}">${vm.name}</option>`);
                    });
                },
                error: function () {
                    alert('Failed to load VMs. Please try again.');
                }
            });
            }
    </script>
@endsection
