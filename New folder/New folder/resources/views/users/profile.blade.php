@extends('layouts.master')
@section('title', 'User Profile')
@section('content')

<div class="container mt-5">
    <h2>User Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>
    </div>

    <h3 class="mt-4">Change Password</h3>
    <form action="{{ route('update_password') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label class="form-label">Old Password:</label>
            <input type="password" class="form-control" name="old_password" required>
            @error('old_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group mb-2">
            <label class="form-label">New Password:</label>
            <input type="password" class="form-control" name="new_password" required>
            @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group mb-2">
            <label class="form-label">Confirm New Password:</label>
            <input type="password" class="form-control" name="new_password_confirmation" required>
        </div>
        <div class="form-group mb-2">
            <button type="submit" class="btn btn-primary">Update Password</button>
        </div>
    </form>
</div>

@endsection
