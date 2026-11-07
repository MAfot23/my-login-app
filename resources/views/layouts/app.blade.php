<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Simple Login System')</title>

    <script>
        // Apply saved theme immediately before render to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --transition-speed: 0.2s;
        }

        body {
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
            transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease;
        }

        .navbar {
            transition: background-color var(--transition-speed) ease, border-color var(--transition-speed) ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: #1e293b;
        }

        .card {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            transition: background-color var(--transition-speed) ease, border-color var(--transition-speed) ease, color var(--transition-speed) ease;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 1rem 1.25rem;
        }

        .theme-toggle-btn {
            cursor: pointer;
            border-radius: 50rem;
            padding: 0.35rem 0.75rem;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            transition: all var(--transition-speed) ease;
        }

        .theme-toggle-btn:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        /* Dark Mode Overrides */
        [data-bs-theme="dark"] body {
            background-color: #0b1120;
            color: #f1f5f9;
        }

        [data-bs-theme="dark"] .navbar {
            background-color: #0f172a !important;
            border-bottom-color: #1e293b !important;
        }

        [data-bs-theme="dark"] .navbar-brand {
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .card {
            background-color: #1e293b;
            border-color: #334155;
            color: #f1f5f9;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        [data-bs-theme="dark"] .card-header {
            background-color: #1e293b !important;
            border-bottom-color: #334155 !important;
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .card-footer {
            background-color: #1e293b !important;
            border-top-color: #334155 !important;
        }

        [data-bs-theme="dark"] .theme-toggle-btn {
            background: #1e293b;
            border-color: #475569;
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .theme-toggle-btn:hover {
            background: #334155;
            border-color: #64748b;
        }

        [data-bs-theme="dark"] .table {
            color: #e2e8f0;
            --bs-table-bg: transparent;
        }

        [data-bs-theme="dark"] .table-light {
            background-color: #0f172a !important;
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .table-hover>tbody>tr:hover>* {
            background-color: rgba(255, 255, 255, 0.04) !important;
            color: #ffffff;
        }

        [data-bs-theme="dark"] .list-group-item {
            background-color: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #0f172a;
            border-color: #60a5fa;
            color: #ffffff;
        }

        [data-bs-theme="dark"] .input-group-text {
            background-color: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #1e293b;
            border-color: #334155;
        }

        [data-bs-theme="dark"] .dropdown-item {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .dropdown-item:hover {
            background-color: #334155;
            color: #ffffff;
        }

        [data-bs-theme="dark"] .dropdown-divider {
            border-top-color: #334155;
        }

        [data-bs-theme="dark"] .text-dark:not(.badge, .badge *) {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .badge.bg-light {
            background-color: #334155 !important;
            color: #f8fafc !important;
            border-color: #475569 !important;
        }

        [data-bs-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] .border {
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .border-bottom {
            border-bottom-color: #334155 !important;
        }

        [data-bs-theme="dark"] .bg-light {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] .bg-white {
            background-color: #1e293b !important;
            color: #f8fafc !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <i class="bi bi-shield-lock-fill text-primary"></i> Simple Login System
                </a>

                <div class="d-flex align-items-center ms-auto gap-2 gap-sm-3">
                    <!-- Light / Dark Mode Toggle Switch -->
                    <button id="themeToggleBtn" class="theme-toggle-btn" type="button" aria-label="Toggle dark/light mode" title="Switch Theme">
                        <i class="bi bi-moon-stars-fill text-primary" id="themeIcon"></i>
                        <span id="themeLabel" class="d-none d-sm-inline">Dark Mode</span>
                    </button>

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
                                <i class="bi bi-speedometer2"></i> <span class="d-none d-md-inline">Admin Panel</span>
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
    <script>
        // Dark / Light Mode Toggle Logic
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            const themeLabel = document.getElementById('themeLabel');

            function updateThemeUI(theme) {
                document.documentElement.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);

                if (theme === 'dark') {
                    themeIcon.className = 'bi bi-sun-fill text-warning';
                    themeLabel.textContent = 'Light Mode';
                    toggleBtn.setAttribute('title', 'Switch to Light Mode');
                } else {
                    themeIcon.className = 'bi bi-moon-stars-fill text-primary';
                    themeLabel.textContent = 'Dark Mode';
                    toggleBtn.setAttribute('title', 'Switch to Dark Mode');
                }
            }

            // Sync with current applied theme on page load
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateThemeUI(currentTheme);

            // Toggle click listener
            toggleBtn.addEventListener('click', function() {
                const activeTheme = document.documentElement.getAttribute('data-bs-theme');
                const nextTheme = activeTheme === 'dark' ? 'light' : 'dark';
                updateThemeUI(nextTheme);
            });
        });
    </script>
</body>
</html>
