@extends('layouts.app')

@section('title', 'Admin Dashboard - Activity Logs')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h3 class="fw-bold mb-1"><i class="bi bi-shield-check text-primary me-2"></i>Admin Dashboard</h3>
        <p class="text-muted mb-0">System Activity Logs & User Monitoring</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
            <i class="bi bi-people me-1"></i> Manage Users
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 border-start border-primary border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Users</div>
                    <div class="fs-4 fw-bold text-dark">{{ $totalUsers }}</div>
                </div>
                <div class="fs-2 text-primary"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-start border-danger border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Administrators</div>
                    <div class="fs-4 fw-bold text-dark">{{ $totalAdmins }}</div>
                </div>
                <div class="fs-2 text-danger"><i class="bi bi-person-badge"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-start border-success border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Total Activity Logs</div>
                    <div class="fs-4 fw-bold text-dark">{{ $totalLogs }}</div>
                </div>
                <div class="fs-2 text-success"><i class="bi bi-journal-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-start border-warning border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-semibold">Today's Logs</div>
                    <div class="fs-4 fw-bold text-dark">{{ $todayLogs }}</div>
                </div>
                <div class="fs-2 text-warning"><i class="bi bi-calendar-event"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Registered Users Management (with Delete Button) -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div class="fw-semibold fs-6">
            <i class="bi bi-people-fill text-primary me-2"></i>Registered Users
            <span class="badge bg-light text-dark border ms-2">{{ $totalUsers }} total</span>
        </div>
        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-arrow-right-circle me-1"></i>View All
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th class="text-end" style="min-width: 170px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentUsers as $user)
                    <tr>
                        <td class="text-muted"><code>#{{ $user->id }}</code></td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-at"></i>{{ $user->username }}
                            </span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->is_admin)
                                <span class="badge bg-danger"><i class="bi bi-shield-check me-1"></i>Admin</span>
                            @else
                                <span class="badge bg-primary">User</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $user->created_at?->format('M d, Y') }}</small>
                        </td>
                        <td class="text-end">
                            @if ($user->id !== auth()->id())
                                <div class="d-inline-flex gap-1">
                                    <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" class="d-inline"
                                          onsubmit="return confirm('Change admin role for {{ $user->username }}?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $user->is_admin ? 'btn-outline-warning' : 'btn-outline-primary' }}">
                                            {{ $user->is_admin ? 'Demote' : 'Promote' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete user @{{ $user->username }}? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete User">
                                            <i class="bi bi-trash-fill me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="badge bg-secondary">Current Admin</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="fw-semibold"><i class="bi bi-funnel me-1"></i> Database Activity Logs</div>
        
        <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex flex-wrap gap-2">
            <select name="action" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                <option value="">All Actions</option>
                @foreach ($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                        {{ $action }}
                    </option>
                @endforeach
            </select>

            <div class="input-group input-group-sm" style="width: 260px;">
                <input type="text" name="search" class="form-control" placeholder="Search user, ip, description..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                @if(request()->hasAny(['action', 'search']))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger" title="Clear Filters"><i class="bi bi-x"></i></a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 70px;">#</th>
                    <th scope="col">Timestamp</th>
                    <th scope="col">User</th>
                    <th scope="col">Action</th>
                    <th scope="col">Description</th>
                    <th scope="col">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td class="text-muted"><code>#{{ $log->id }}</code></td>
                        <td>
                            <div class="small fw-semibold">{{ $log->created_at->format('Y-m-d H:i:s') }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            @if ($log->user)
                                <div class="fw-semibold">{{ $log->user->name }}</div>
                                <small class="text-muted">{{ '@' . $log->user->username }}</small>
                            @else
                                <span class="badge bg-secondary">{{ $log->username ?? 'Guest/Anonymous' }}</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badgeClass = match($log->action) {
                                    'LOGIN' => 'bg-success',
                                    'REGISTER' => 'bg-primary',
                                    'LOGOUT' => 'bg-secondary',
                                    'FAILED_LOGIN' => 'bg-danger',
                                    'UNAUTHORIZED_ACCESS' => 'bg-warning text-dark',
                                    default => 'bg-info text-dark',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $log->action }}</span>
                        </td>
                        <td>
                            <span class="small">{{ $log->description }}</span>
                        </td>
                        <td>
                            <code class="small">{{ $log->ip_address ?? '127.0.0.1' }}</code>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No activity logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
