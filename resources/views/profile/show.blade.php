@extends('layout.app')

@section('content')
<div class="main-panel">
    @include('components.navbarHeader')
    <div class="container">
        <div class="page-inner">
        <div class="page-header">
        <h4 class="page-title">User Profile</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="fas fa-angle-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Profile</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-header" style="background-image: url('{{ asset('assets/img/blogpost.jpg') }}')">
                    <div class="profile-picture">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('assets/img/icon.png') }}" alt="Profile Image" class="avatar-img rounded-circle">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name">{{ $user->name }}</div>
                        <div class="job">{{ $user->role->name }}</div>
                        <div class="desc">{{ $user->email }}</div>
                        <div class="social-media">
                            <a class="btn btn-info btn-twitter btn-sm btn-link" href="#"> 
                                <span class="btn-label just-icon"><i class="fab fa-twitter"></i> </span>
                            </a>
                            <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                                <span class="btn-label just-icon"><i class="fab fa-google"></i> </span> 
                            </a>
                            <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#"> 
                                <span class="btn-label just-icon"><i class="fab fa-facebook"></i> </span> 
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row user-stats text-center">
                        <div class="col">
                            <div class="number">{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</div>
                            <div class="title">Joined</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Profile</div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" value="{{ $user->role->name }}" disabled>
                            <small class="form-text text-muted">Your role cannot be changed here. Contact an administrator for role changes.</small>
                        </div>
                        
                        <hr>
                        <h4>Change Password</h4>
                        <p class="text-muted">Leave blank if you don't want to change your password</p>
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection 