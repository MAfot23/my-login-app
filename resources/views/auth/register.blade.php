@extends('layouts.app')

@section('title', 'Register - User Login System')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Create an Account</h5>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Full Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                               placeholder="e.g. John Doe">
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Unique Username (Cannot be random numbers) -->
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Unique Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                   name="username" value="{{ old('username') }}" required autocomplete="username"
                                   placeholder="e.g. johndoe99"
                                   pattern="^[a-zA-Z][a-zA-Z0-9_.-]{2,19}$"
                                   title="Must start with a letter, 3-20 characters, cannot consist only of numbers">
                        </div>
                        <div class="form-text text-muted">
                            <small><i class="bi bi-info-circle"></i> Must start with a letter, 3-20 characters. Cannot be only numbers.</small>
                        </div>
                        @error('username')
                            <span class="text-danger small mt-1 d-block" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email"
                               placeholder="name@example.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password"
                               placeholder="Minimum 8 characters">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label fw-semibold">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="Repeat password">
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary py-2 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Register Account
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
