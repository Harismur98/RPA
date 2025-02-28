@extends('layout.app')

@section('content')
<div class="main-panel">
    @include('components.navbarHeader')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Job Details</h3>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Job #{{ $job->id }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Status</h5>
                                    <span class="badge {{ $job->status == 'completed' ? 'badge-success' : ($job->status == 'failed' ? 'badge-danger' : 'badge-warning') }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <h5>API Key</h5>
                                    <p>{{ $job->api_key }}</p>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Created At</h5>
                                    <p>{{ $job->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Updated At</h5>
                                    <p>{{ $job->updated_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                            </div>

                            @if($job->result)
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5>Result</h5>
                                    <pre class="bg-light p-3 rounded">{{ json_encode($job->result, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                            @endif

                            @if($job->data)
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Data</h5>
                                    <pre class="bg-light p-3 rounded">{{ json_encode($job->data, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.footer')
</div>

@endsection 