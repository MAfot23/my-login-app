@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <!-- Welcome Card -->
        <div class="card mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #1e293b, #334155); color: white;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="badge {{ Auth::user()->is_admin ? 'bg-danger' : 'bg-primary' }} mb-2">
                            {{ Auth::user()->is_admin ? 'Administrator' : 'Standard User' }}
                        </span>
                        <h3 class="mb-1 fw-bold">Welcome back, {{ Auth::user()->name }}!</h3>
                        <p class="text-white-50 mb-0">Username: <strong>{{ '@' . Auth::user()->username }}</strong> &bull; Email: {{ Auth::user()->email }}</p>
                    </div>
                    @if (Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-lg shadow-sm">
                            <i class="bi bi-speedometer2 me-1"></i> Open Admin Panel
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Account Info & Recent Personal Activities -->
        <div class="row g-4">
            <div class="col-md-5">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <i class="bi bi-person-lines-fill text-primary me-2"></i><strong>Account Details</strong>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Full Name</span>
                                <span class="fw-semibold">{{ Auth::user()->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Unique Username</span>
                                <span class="badge bg-light text-dark border">{{ '@' . Auth::user()->username }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Email</span>
                                <span>{{ Auth::user()->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Account Role</span>
                                <span class="badge {{ Auth::user()->is_admin ? 'bg-danger' : 'bg-primary' }}">
                                    {{ Auth::user()->is_admin ? 'Admin' : 'Regular User' }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Member Since</span>
                                <span>{{ Auth::user()->created_at?->format('M d, Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-clock-history text-primary me-2"></i><strong>Your Recent Activity</strong>
                        </div>
                        <small class="text-muted">Last 5 actions</small>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $userLogs = \App\Models\ActivityLog::where('user_id', Auth::id())->latest()->take(5)->get();
                        @endphp
                        <ul class="list-group list-group-flush">
                            @forelse($userLogs as $log)
                                <li class="list-group-item py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge {{ $log->action === 'LOGIN' ? 'bg-success' : ($log->action === 'LOGOUT' ? 'bg-secondary' : 'bg-primary') }}">
                                            {{ $log->action }}
                                        </span>
                                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="small text-dark">{{ $log->description }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">IP: {{ $log->ip_address }}</div>
                                </li>
                            @empty
                                <li class="list-group-item text-center py-4 text-muted">
                                    No activity logs yet.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
