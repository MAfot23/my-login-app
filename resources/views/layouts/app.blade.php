<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Simple User Login System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: 700;
            color: #1e293b;
        }
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 1rem 1.25rem;
        }
        .badge-admin {
            background-color: #ef4444;
            color: white;
        }
        .badge-user {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <i class="bi bi-shield-lock-fill text-primary"></i> Auth & Activity System
                </a>

                <div class="d-flex align-items-center ms-auto gap-3">
                    @guest
                        @if (Route::has('login'))
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Login</a>
                        @endif
                        @if (Route::has('register'))
                            <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Register</a>
                        @endif
                    @else
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-danger d-flex align-items-center gap-1">
                                <i class="bi bi-speedometer2"></i> Admin Panel
                            </a>
                        @endif

                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle border d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <strong>{{ Auth::user()->name }}</strong>
                                <span class="badge {{ Auth::user()->is_admin ? 'bg-danger' : 'bg-primary' }}">
                                    {{ Auth::user()->is_admin ? 'Admin' : 'User' }}
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li>
                                    <div class="dropdown-item-text text-muted small">
                                        {{ '@' . Auth::user()->username }}<br>
                                        {{ Auth::user()->email }}
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Auth::user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-journal-text me-2"></i>Activity Logs</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users') }}"><i class="bi bi-people me-2"></i>Manage Users</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-house me-2"></i>User Dashboard</a></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
