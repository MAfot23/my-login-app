@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h3 class="fw-bold mb-1"><i class="bi bi-people text-primary me-2"></i>User Management</h3>
        <p class="text-muted mb-0">View registered users and assign administrator privileges.</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Logs
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><code>#{{ $user->id }}</code></td>
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
                                <span class="badge bg-primary">Regular User</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $user->created_at?->format('M d, Y') }}</small>
                        </td>
                        <td class="text-end">
                            @if ($user->id !== auth()->id())
                                <div class="d-inline-flex gap-1">
                                    <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" class="d-inline"
                                          onsubmit="return confirm('Change admin status for {{ $user->username }}?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $user->is_admin ? 'btn-outline-warning' : 'btn-outline-primary' }}">
                                            {{ $user->is_admin ? 'Demote' : 'Promote' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to permanently delete user @{{ $user->username }}? This action cannot be undone.');">
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

    @if ($users->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
