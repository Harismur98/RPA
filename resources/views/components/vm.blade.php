@extends('layout.app')

@section('content')
<div class="main-panel">
    @include('components.navbarHeader')
    
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
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
            </div>
            <div class="row">
                <!-- The table column -->
                <div class="col-md-12" id="vm-table-container">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">VMs</h4>
                                <button
                                    class="btn btn-primary btn-round ms-auto"
                                    id="addVmButton"
                                >
                                    <i class="fa fa-plus"></i>
                                    Add VM
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="vm-table" class="display table table-striped table-hover">
                            <thead>
                              <tr>
                                <th>Process Name</th>
                                <th>VM</th>
                                <th>Office</th>
                                <th style="width: 10%">Action</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Action</th>
                              </tr>
                            </tfoot>
                            <tbody>
                                @foreach($vms as $vm)
                                    <tr>
                                        <td>{{ $vm->name }}</td>
                                        <td>{{ $vm->api_key }}</td>
                                        <td>{{ $vm->last_handshake }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" class="btn btn-link btn-primary btn-edit-vm" data-vm-id="{{ $vm->id }}" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-link btn-info btn-view-vm" data-vm-id="{{ $vm->id }}" data-bs-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <form action="{{ route('vms.destroy', $vm->id) }}" method="POST" style="display:inline-block;">
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
                    <div class="col-md-6" id="vm-form-container" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New VM</h4>
                            </div>
                            <div class="card-body">
                                
                                <form action="{{ route('vms.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="api_key">API Key</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="api_key" name="api_key" readonly>
                                            <button type="button" class="btn btn-primary" id="generateApiKeyButton">Generate API Key</button>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save VM</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Form Column, hidden initially -->
                    <div class="col-md-6" id="vm-edit-form-container" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit VM</h4>
                            </div>
                            <div class="card-body">
                                <form id="editVmForm" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="edit_name">Name</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_api_key">API Key</label>
                                        <input type="text" class="form-control" id="edit_api_key" name="api_key" readonly>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update VM</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- View Form Column, hidden initially -->
                    <div class="col-md-6" id="vm-view-form-container" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View VM</h4>
                            </div>
                            <div class="card-body">
                                <div>
                                    <strong>Name:</strong>
                                    <span id="view_name"></span>
                                </div>
                                <div>
                                    <strong>API Key:</strong>
                                    <span id="view_api_key"></span>
                                </div>
                                <div>
                                    <strong>Last Handshake:</strong>
                                    <span id="view_last_handshake"></span>
                                </div>
                                <div class="card-footer">
                                    <button id="testVmButton" class="btn btn-warning">Test VM</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>			

    @include('components.footer')

    <script>
        document.getElementById('addVmButton').addEventListener('click', function() {
            // Change the table's grid from col-md-12 to col-md-6
            document.getElementById('vm-table-container').classList.remove('col-md-12');
            document.getElementById('vm-table-container').classList.add('col-md-6');

            // Show the form container
            document.getElementById('vm-form-container').style.display = 'block';
        });

        document.getElementById('generateApiKeyButton').addEventListener('click', function() {
            // Make an AJAX request to generate the API key
            fetch('{{ route("generate.api.key") }}')
                .then(response => response.json())
                .then(data => {
                    // Update the input field with the generated API key
                    document.getElementById('api_key').value = data.api_key;
                })
                .catch(error => console.error('Error:', error));
        });


        document.getElementById('addVmButton').addEventListener('click', function () {
            // Adjust table width and show the Add VM form
            document.getElementById('vm-table-container').classList.remove('col-md-12');
            document.getElementById('vm-table-container').classList.add('col-md-6');

            // Show the Add VM form, hide others
            document.getElementById('vm-form-container').style.display = 'block';
            document.getElementById('vm-edit-form-container').style.display = 'none';
            document.getElementById('vm-view-form-container').style.display = 'none';
        });

        document.querySelectorAll('.btn-edit-vm').forEach(button => {
            button.addEventListener('click', function () {
                const vmId = this.dataset.vmId;

                // Make an AJAX request to fetch the VM details
                fetch(`/vms/${vmId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate the Edit form with VM data
                        document.getElementById('edit_name').value = data.name;
                        document.getElementById('edit_api_key').value = data.api_key;

                        // Set the form action to the correct update route
                        document.getElementById('editVmForm').action = `/vms/${vmId}`;

                        // Adjust layout and display Edit form
                        document.getElementById('vm-table-container').classList.remove('col-md-12');
                        document.getElementById('vm-table-container').classList.add('col-md-6');

                        document.getElementById('vm-edit-form-container').style.display = 'block';
                        document.getElementById('vm-form-container').style.display = 'none';
                        document.getElementById('vm-view-form-container').style.display = 'none';
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        document.querySelectorAll('.btn-view-vm').forEach(button => {
            button.addEventListener('click', function () {
                const vmId = this.dataset.vmId;

                // Make an AJAX request to fetch the VM details
                fetch(`/vms/${vmId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate the View form with VM data
                        document.getElementById('view_name').textContent = data.name;
                        document.getElementById('view_api_key').textContent = data.api_key;
                        document.getElementById('view_last_handshake').textContent = data.last_handshake;

                        // Adjust layout and display View form
                        document.getElementById('vm-table-container').classList.remove('col-md-12');
                        document.getElementById('vm-table-container').classList.add('col-md-6');

                        document.getElementById('vm-view-form-container').style.display = 'block';
                        document.getElementById('vm-form-container').style.display = 'none';
                        document.getElementById('vm-edit-form-container').style.display = 'none';
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

      </script>
@endsection
