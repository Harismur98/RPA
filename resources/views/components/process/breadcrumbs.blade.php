<!-- Breadcrumbs -->
<div class="page-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">RPA Process</li>
            {{-- @if(isset($process))
                <li class="breadcrumb-item active" aria-current="page">{{ $process->process_name }}</li>
            @endif
            @if(isset($step))
                <li class="breadcrumb-item active" aria-current="page">{{ $step->step_name }}</li>
            @endif
            @if(isset($task))
                <li class="breadcrumb-item active" aria-current="page">{{ $task->task_name }}</li>
            @endif --}}
        </ol>
    </nav>
</div>

<style>
.page-breadcrumb {
    margin-bottom: 1.5rem;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item {
    font-size: 14px;
}

.breadcrumb-item a {
    color: #1572E8;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #1a2035;
}

.breadcrumb-item.active {
    color: #6c757d;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: #6c757d;
}
</style> 