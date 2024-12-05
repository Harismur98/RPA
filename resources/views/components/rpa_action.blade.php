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
                <div class="col-md-12" id="action-table-container">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Action</h4>
                                <button
                                    class="btn btn-primary btn-round ms-auto"
                                    id="addactionButton"
                                >
                                    <i class="fa fa-plus"></i>
                                    Add Action
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="action-table" class="display table table-striped table-hover">
                            <thead>
                              <tr>
                                <th>Fanction Name</th>
                                <th style="width: 10%">Action</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Function Name</th>
                                <th>Action</th>
                              </tr>
                            </tfoot>
                            <tbody>
                                @foreach($actions as $action)
                                    <tr>
                                        <td>{{ $action->function_name }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('rpa.action.edit', $action->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit Task">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('rpa.action.destroy', $action->id) }}" method="POST" style="display:inline-block;">
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
                    <div class="col-md-6" id="action-form-container" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New Action</h4>
                            </div>
                            <div class="card-body">
                                
                                <form action="{{ route('rpa.action.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Function Name</label>
                                        <input type="text" class="form-control" name="function_name" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save action</button>
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
        document.getElementById('addactionButton').addEventListener('click', function() {
            // Change the table's grid from col-md-12 to col-md-6
            document.getElementById('action-table-container').classList.remove('col-md-12');
            document.getElementById('action-table-container').classList.add('col-md-6');

            // Show the form container
            document.getElementById('action-form-container').style.display = 'block';
        });

      </script>
@endsection
