@extends('layout.app')

@section('content')
<div class="main-panel">
    @include('components.navbarHeader')
    
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">RPA Process</h3>
                @include('components.process.breadcrumbs')
            </div>

            <div class="row">
                <!-- Process Section -->
                <div class="tab-content">
                    <div class="tab-pane active" id="process-content" role="tabpanel">
                        @include('components.process.tables.process-table')
                        @include('components.process.details.process-details')
                        @include('components.process.forms.process-form')
                    </div>

                    <!-- Step Section -->
                    <div class="tab-pane fade" id="step-content" role="tabpanel">
                        @include('components.process.tables.step-table')
                        @include('components.process.details.step-details')
                        @include('components.process.forms.step-form')
                    </div>

                    <!-- Task Section -->
                    <div class="tab-pane fade" id="task-content" role="tabpanel">
                        @include('components.process.tables.task-table')
                        @include('components.process.details.task-details')
                        @include('components.process.forms.task-form')
                        @include('components.process.tables.exception-table')
                        @include('components.process.forms.step-exception-form')
                        @include('components.process.forms.task-exception-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/process/main.js') }}"></script>
<script src="{{ asset('js/process/forms.js') }}"></script>
<script src="{{ asset('js/process/tables.js') }}"></script>
<script src="{{ asset('js/process/details.js') }}"></script>
<script src="{{ asset('js/process/file-upload.js') }}"></script>
@endpush 