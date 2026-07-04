@extends('admin.layouts.app')

@section('page-title', 'Profile')

@section('content')

    <div class="card p-4 shadow-sm">

        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active">User Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings') }}">Settings</a>
            </li>
        </ul>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                </div>

                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Profile Image</label>
                    <input type="file" name="profile_image" class="form-control">
                </div>

                <div class="col-md-6">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                @if ($user->profile_image)
                    <img src="{{ asset('uploads/' . $user->profile_image) }}" width="80" class="img-thumbnail">
                @endif
            </div>
            

            <button class="btn btn-primary">Update Profile</button>
        </form>

    </div>

@endsection
