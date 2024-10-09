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
                    <button id="addJobButton" class="btn btn-primary">Add Job</button>
                </div>
                <form id="addJobForm" action="{{ route('rpa.template.addJob') }}" method="POST" style="display:none;">
                    @csrf
                    <input type="hidden" name="selected_job_id" id="selectedJobId" value="">
                </form>
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
                                    id="addjOBButton"
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
                                    <tr data-id="{{ $jobTemplate->id }}">
                                        <td>{{ $jobTemplate->name }}</td>
                                        <td>{{ $jobTemplate->process ? $jobTemplate->process->process_name : 'No process' }}</td>
                                        <td>{{ $jobTemplate->vm ? $jobTemplate->vm->name : 'No VM' }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('rpa.template.edit', $jobTemplate->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit Task">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('rpa.template.destroy', $jobTemplate->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
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

                  <!-- The form column, hidden initially -->
                <div class="col-md-6" id="template-form-container" style="display: none;">
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
                                    <label for="processSelect">Select Process</label>
                                    <select class="form-select" name="process_id" id="processSelect" required>
                                        <option value="" disabled selected>Loading processes...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="vmSelect">Select VM</label>
                                    <select class="form-select" name="vm_id" id="vmSelect" required>
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
                // Set the selected job ID in the hidden form
                $('#selectedJobId').val(selectedJobId);
                
                // Submit the form
                $('#addJobForm').submit();
            } else {
                alert('Please select a job template.');
            }
        });
        
        document.querySelector('#button').addEventListener('click', function () {
            alert(table.rows('.selected').data().length + ' row(s) selected');
        });


        document.getElementById('addjOBButton').addEventListener('click', function() {
            // Change the table's grid from col-md-12 to col-md-6
            document.getElementById('template-table-container').classList.remove('col-md-12');
            document.getElementById('template-table-container').classList.add('col-md-6');

            // Show the form container
            document.getElementById('template-form-container').style.display = 'block';

            $.ajax({
                url: '{{ route("get.processes") }}',
                method: 'GET',
                success: function(data) {
                    var select = $('#processSelect');
                    select.empty();  // Clear the previous options
                    select.append('<option value="" disabled selected>Select a process</option>');

                    // Populate the select dropdown with the processes
                    $.each(data, function(index, process) {
                        select.append('<option value="' + process.id + '">' + process.process_name + '</option>');
                    });
                },
                error: function() {
                    alert('Failed to load processes. Please try again.');
                }
            });

            $.ajax({
                url: '{{ route("get.vm") }}',
                method: 'GET',
                success: function(data) {
                    var select = $('#vmSelect');
                    select.empty();  // Clear the previous options
                    select.append('<option value="" disabled selected>Select a vm</option>');

                    // Populate the select dropdown with the processes
                    $.each(data, function(index, vm) {
                        select.append('<option value="' + vm.id + '">' + vm.name + '</option>');
                    });
                },
                error: function() {
                    alert('Failed to load processes. Please try again.');
                }
            });
        });


    </script>
@endsection
