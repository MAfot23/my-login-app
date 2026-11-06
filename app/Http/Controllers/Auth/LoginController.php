<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Allow login with either username or email.
     */
    public function username()
    {
        $login = request()->input('login') ?? request()->input('email');
        
        // Determine whether input is email or username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        request()->merge([$fieldType => strtolower((string) $login)]);
        
        return $fieldType;
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Please enter your username or email address.',
        ]);
    }

    /**
     * Handle post-authentication logic (admin redirection + activity log).
     */
    protected function authenticated(Request $request, $user)
    {
        ActivityLog::record(
            action: 'LOGIN',
            description: "User {$user->username} (" . ($user->is_admin ? 'Admin' : 'Regular User') . ") logged in.",
            user: $user,
            request: $request
        );

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard')
                ->with('status', "Welcome back, Admin {$user->name}!");
        }

        return redirect()->intended($this->redirectPath())
            ->with('status', "Welcome back, {$user->name}!");
    }

    /**
     * Handle failed login attempt (activity log).
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $identifier = $request->input('login') ?? $request->input('email') ?? 'unknown';

        ActivityLog::record(
            action: 'FAILED_LOGIN',
            description: "Failed login attempt for identifier: {$identifier}",
            user: null,
            request: $request
        );

        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application and log the event.
     */
    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            ActivityLog::record(
                action: 'LOGOUT',
                description: "User {$user->username} logged out.",
                user: $user,
                request: $request
            );
        }

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'You have been logged out successfully.');
    }
}
