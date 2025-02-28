@extends('layout.app')

@section('content')
<div class="main-panel">
    @include('components.navbarHeader')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Job Status</h3>
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
                        <a href="#">RPA</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Job Status</a>
                    </li>
                </ul>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Jobs List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>API Key</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobs as $job)
                                        <tr>
                                            <td>{{ $job->id }}</td>
                                            <td>{{ $job->api_key }}</td>
                                            <td>
                                                <span class="badge {{ $job->status == 'completed' ? 'badge-success' : ($job->status == 'failed' ? 'badge-danger' : ($job->status == 'stopped' ? 'badge-secondary' : 'badge-warning')) }}">
                                                    {{ ucfirst($job->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $job->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($job->status != 'stopped' && $job->status != 'completed' && $job->status != 'failed')
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="stopJob({{ $job->id }})" title="Stop Job">
                                                        <i class="fas fa-stop"></i>
                                                    </button>
                                                    @endif
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteJob({{ $job->id }})" title="Delete Job">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>

                                                <!-- Hidden forms for stop and delete actions -->
                                                <form id="stop-form-{{ $job->id }}" action="{{ route('jobs.stop', $job->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                <form id="delete-form-{{ $job->id }}" action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $jobs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.footer')
</div>

<script>
    // Alert auto-dismiss
    window.setTimeout(function() {
        $("#success-alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);

    function stopJob(jobId) {
        if (confirm('Are you sure you want to stop this job?')) {
            document.getElementById('stop-form-' + jobId).submit();
        }
    }

    function deleteJob(jobId) {
        if (confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
            document.getElementById('delete-form-' + jobId).submit();
        }
    }
</script>

@endsection

