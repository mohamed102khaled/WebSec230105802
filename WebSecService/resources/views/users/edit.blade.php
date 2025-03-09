@extends('layouts.master')
@section('title', 'Edit User')
@section('content')

<div class="container mt-5">
    <h2>Edit User</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users_save', $user->id ?? '') }}" method="POST">
        @csrf

        <div class="form-group mb-2">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name ?? '') }}" required>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email ?? '') }}" required>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Role:</label>
            <select name="role" class="form-control" required>
                <option value="user" {{ (old('role', $user->role ?? '') == 'user') ? 'selected' : '' }}>User</option>
                <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="form-group mb-2">
    <label class="form-label">Security Question:</label>
    <select name="security_question" class="form-control">
        <option value="">-- Select a Security Question --</option>
        <option value="What is your pet's name?" {{ old('security_question', $user->security_question ?? '') == "What is your pet's name?" ? 'selected' : '' }}>What is your pet's name?</option>
        <option value="What is your mother's maiden name?" {{ old('security_question', $user->security_question ?? '') == "What is your mother's maiden name?" ? 'selected' : '' }}>What is your mother's maiden name?</option>
        <option value="What city were you born in?" {{ old('security_question', $user->security_question ?? '') == "What city were you born in?" ? 'selected' : '' }}>What city were you born in?</option>
    </select>
</div>

<div class="form-group mb-2">
    <label class="form-label">Security Answer:</label>
    <input type="text" class="form-control" name="security_answer" placeholder="Enter new answer or leave blank to keep current">
</div>



        <div class="form-group mb-2">
            <label class="form-label">New Password (leave empty to keep current password):</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Confirm New Password:</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

@endsection
