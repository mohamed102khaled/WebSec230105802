@extends('layouts.master')
@section('title', 'Edit User')
@section('content')

<div class="container mt-5">
    <h2>Edit User</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


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
            <input type="text" class="form-control" value="{{ ucfirst($user->role ?? 'User') }}" disabled>
            <input type="hidden" name="role" value="{{ $user->role ?? 'user' }}">
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

        @can('edit_users')
        <div class="col-12 mb-2">
            <label for="roles" class="form-label">Roles:</label>
            <select multiple class="form-select" name="roles[]">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $role->taken ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Permissions:</label>
            @foreach($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input"
                        {{ $permission->assigned ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
        @endcan

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

@endsection
