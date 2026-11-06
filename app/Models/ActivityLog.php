<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'action',
        'description',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, ?string $description = null, ?User $user = null, ?Request $request = null): self
    {
        $request = $request ?? request();
        $user = $user ?? (auth()->check() ? auth()->user() : null);

        $resolvedUsername = $user?->username 
            ?? $request?->input('username') 
            ?? $request?->input('login') 
            ?? $request?->input('email')
            ?? 'Guest';

        return self::create([
            'user_id' => $user?->id,
            'username' => $resolvedUsername,
            'action' => strtoupper($action),
            'description' => $description,
            'ip_address' => $request?->ip(),
            'user_agent' => substr((string) ($request?->userAgent() ?? ''), 0, 500),
        ]);
    }
}
