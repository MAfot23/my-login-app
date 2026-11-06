@extends('layouts.app')

@section('title', 'Login - User & Admin System')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</span>
                <span class="badge bg-secondary">User & Admin</span>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Username or Email -->
                    <div class="mb-3">
                        <label for="login" class="form-label fw-semibold">Username or Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input id="login" type="text" class="form-control @error('login') is-invalid @enderror"
                                   name="login" value="{{ old('login') }}" required autocomplete="username" autofocus
                                   placeholder="Enter username or email">
                        </div>
                        @error('login')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            @if (Route::has('password.request'))
                                <a class="small text-decoration-none" href="{{ route('password.request') }}">Forgot?</a>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password"
                                   placeholder="Enter your password">
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">Remember me</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Log In
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3 pt-3 border-top">
                    <small class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Register here</a></small>
                </div>
            </div>
        </div>

        <!-- Helpful Admin Quick Info Box -->
        <div class="card mt-3 border-info-subtle bg-light">
            <div class="card-body py-2 px-3 small text-muted">
                <strong class="text-dark"><i class="bi bi-shield-check text-success me-1"></i> Admin Credentials:</strong>
                <div>Username: <code>admin</code> | Password: <code>password123</code></div>
                <div class="text-secondary mt-1">Admins are automatically redirected to the Activity Logs Dashboard.</div>
            </div>
        </div>
    </div>
</div>
@endsection
