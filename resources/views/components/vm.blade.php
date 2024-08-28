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
                                                <a href="{{ route('vms.edit', $vm->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit Task">
                                                    <i class="fa fa-edit"></i>
                                                </a>
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
                                        <input type="text" class="form-control" name="api_key" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_handshake">Last Handshake</label>
                                        <input type="datetime-local" class="form-control" name="last_handshake">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save VM</button>
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
  
          document.getElementById('addVmButton').addEventListener('click', function() {
                // Change the table's grid from col-md-12 to col-md-6
                document.getElementById('vm-table-container').classList.remove('col-md-12');
                document.getElementById('vm-table-container').classList.add('col-md-6');

                // Show the form container
                document.getElementById('vm-form-container').style.display = 'block';
            });
      </script>