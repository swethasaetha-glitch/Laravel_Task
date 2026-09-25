@extends('layouts.app')

@section('title', 'Sign Up - Track Tech Solutions')

@section('content')
<div class="row justify-content-center align-items-center style="min-height: 85vh;"">
    <div class="col-md-6 col-lg-5">
        <div class="text-center mb-4">
            <h1 class="fw-extrabold text-dark" style="font-size: 2.2rem; letter-spacing: -0.03em;">Track Tech Solutions</h1>
            <p class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.1em;">Garment Production System</p>
        </div>

        <div class="card card-custom p-4 shadow-lg border-0">
            <div class="card-body p-2">
                <div class="mb-4 text-center">
                    <h3 class="fw-bold text-dark">Create Account</h3>
                    <p class="text-muted small mb-0">Sign up to access the garment production portal</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small text-muted">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" id="name" class="form-control form-control-custom border-start-0 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. John Doe">
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-muted">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control form-control-custom border-start-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="john@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold small text-muted">Role / Position</label>
                        <select name="role" id="role" class="form-select form-select-custom @error('role') is-invalid @enderror" required>
                            <option value="Production Manager" {{ old('role') == 'Production Manager' ? 'selected' : '' }}>Production Manager</option>
                            <option value="Cutting Operator" {{ old('role') == 'Cutting Operator' ? 'selected' : '' }}>Cutting Operator</option>
                            <option value="Quality Inspector" {{ old('role') == 'Quality Inspector' ? 'selected' : '' }}>Quality Inspector</option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold small text-muted">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-custom @error('password') is-invalid @enderror" required placeholder="••••••••">
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold small text-muted">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-custom" required placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-blue w-100 py-3 mt-2 fw-bold text-center justify-content-center">
                        <i class="bi bi-person-plus-fill me-1"></i> Sign Up
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <p class="text-muted small mb-0">Already have an account? <a href="{{ route('login') }}" class="fw-bold text-primary text-decoration-none">Log In</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
