<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate('created_at', today())->count();

        $query = ActivityLog::with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('username', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('ip_address', 'like', $searchTerm);
            });
        }

        $logs = $query->paginate(15)->withQueryString();
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.dashboard', compact('totalUsers', 'totalAdmins', 'totalLogs', 'todayLogs', 'logs', 'actions'));
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own admin status.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        ActivityLog::record(
            action: 'ADMIN_ROLE_CHANGE',
            description: 'Admin ' . auth()->user()->username . ' changed admin status of ' . $user->username . ' to ' . ($user->is_admin ? 'Admin' : 'User') . '.'
        );

        return back()->with('status', 'User ' . $user->username . ' role updated successfully.');
    }
}
