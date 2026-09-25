@extends('layouts.app')

@section('title', 'Log In - Track Tech Solutions')

@section('content')
<div class="row justify-content-center align-items-center style="min-height: 85vh;"">
    <div class="col-md-5 col-lg-4">
        <div class="text-center mb-4">
            <h1 class="fw-extrabold text-dark" style="font-size: 2.2rem; letter-spacing: -0.03em;">Track Tech Solutions</h1>
            <p class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.1em;">Garment Production System</p>
        </div>

        <div class="card card-custom p-4 shadow-lg border-0">
            <div class="card-body p-2">
                <div class="mb-4 text-center">
                    <h3 class="fw-bold text-dark">Welcome Back</h3>
                    <p class="text-muted small mb-0">Sign in to your production management account</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-muted">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control form-control-custom border-start-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold small text-muted">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control form-control-custom border-start-0 @error('password') is-invalid @enderror" required placeholder="••••••••">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted small" for="remember">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-blue w-100 py-3 fw-bold text-center justify-content-center">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Log In
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <p class="text-muted small mb-0">Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Sign Up</a></p>
                </div>
            </div>
            <div class="card-footer bg-light border-0 text-center py-2 text-muted small rounded-bottom">
                Default Credentials: <code>admin@example.com</code> / <code>ChangeMe@123</code>
            </div>
        </div>
    </div>
</div>
@endsection
