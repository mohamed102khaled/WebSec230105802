@extends('layouts.master')
@section('title', 'Add/Edit User')
@section('content')

<div class="container mt-5">
    <form action="{{ route('users_save', $user->id ?? null) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" required value="{{ old('name', $user->name ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" required value="{{ old('email', $user->email ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Role:</label>
            <select class="form-select" name="role">
                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" class="form-control" name="password" {{ $user->exists ? '' : 'required' }}>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

@endsection
