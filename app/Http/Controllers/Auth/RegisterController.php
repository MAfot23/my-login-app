<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'unique:users,username',
                // Must start with a letter, letters/numbers/underscore/dots allowed, minimum 2 alphabetic letters
                'regex:/^[a-zA-Z][a-zA-Z0-9_.-]*$/',
                'not_regex:/^[0-9]+$/',
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'username.required' => 'A unique username is required.',
            'username.unique' => 'This username is already taken. Please choose another.',
            'username.regex' => 'Username must start with a letter and contain valid characters (letters, numbers, underscores, dots).',
            'username.not_regex' => 'Username cannot be composed purely of random numbers or digits.',
            'username.min' => 'Username must be at least 3 characters long.',
            'username.max' => 'Username cannot exceed 20 characters.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => strtolower($data['username']),
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        ActivityLog::record(
            action: 'REGISTER',
            description: "New user registered: {$user->username} ({$user->email})",
            user: $user,
            request: $request
        );

        return redirect()->route('login')
            ->with('status', "Registration successful for {$user->username}! You can now log in.");
    }
}
