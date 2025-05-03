@extends('layouts.master')
@section('title', 'Login')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center fs-4">
                    Login
                </div>

                <div class="card-body">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Login Form --}}
                    <form action="{{ route('do_login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('forgot_password') }}" class="text-decoration-none">Forgot Password?</a>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <hr>

                    <div class="text-center mb-3">Or login with:</div>

                    {{-- Social Login Buttons with Icons --}}
                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('login_with_google') }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center gap-2">
                            <img src="https://img.icons8.com/color/20/google-logo.png" alt="Google Logo">
                            <span>Login with Google</span>
                        </a>
                        <a href="{{ route('login_with_facebook') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center gap-2">
                            <img src="https://img.icons8.com/fluency/20/facebook-new.png" alt="Facebook Logo">
                            <span>Login with Facebook</span>
                        </a>
                        <a href="{{ route('login_with_github') }}" class="btn btn-outline-dark d-flex align-items-center justify-content-center gap-2">
                            <img src="https://img.icons8.com/ios-glyphs/20/000000/github.png" alt="GitHub Logo">
                            <span>Login with GitHub</span>
                        </a>
                        <a href="{{ route('login_with_linkedin') }}" class="btn btn-outline-info d-flex align-items-center justify-content-center gap-2">
                            <img src="https://img.icons8.com/color/20/linkedin.png" alt="LinkedIn Logo">
                            <span>Login with LinkedIn</span>
                        </a>
                    </div>
                    <div class="text-center mb-3">Certificate Login:</div>
                    {{-- Login with Certificate Button --}}
                    <form action="{{ route('login.certificate') }}" method="POST">
                        @csrf
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                                <img src="https://img.icons8.com/ios-filled/20/000000/certificate.png" alt="Certificate Icon">
                                <span>Certificate</span>
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        Create Account: <a href="{{ route('register') }}" class="text-decoration-none">register here</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
