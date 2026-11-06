@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-4 fw-bold mb-3">Welcome to our Website</h1>

    @guest
        <p class="text-muted mb-4">A Simple Login Application.</p>

        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('login') }}" class="btn btn-primary px-4">Log In</a>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4">Register</a>
        </div>
    @else
        <p class="text-muted mb-4">Are you ready to create an account and start using our application? Sign up now to get started!</p>

        <a href="{{ route('home') }}" class="btn btn-success px-4">Go to Dashboard</a>
    @endguest
</div>
@endsection
