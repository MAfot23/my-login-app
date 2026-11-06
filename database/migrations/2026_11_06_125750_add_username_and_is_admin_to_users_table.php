<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->boolean('is_admin')->default(false)->after('password');
        });

        // Ensure any existing users get a valid unique username starting with a letter
        $users = User::all();
        foreach ($users as $user) {
            if (empty($user->username)) {
                $base = preg_replace('/[^a-zA-Z0-9]/', '', strtolower(explode('@', $user->email)[0] ?? 'user'));
                if (empty($base) || is_numeric($base[0])) {
                    $base = 'user' . $base;
                }
                $candidate = substr($base, 0, 15);
                $counter = 1;
                while (User::where('username', $candidate)->where('id', '!=', $user->id)->exists()) {
                    $candidate = substr($base, 0, 12) . $counter++;
                }
                $user->username = $candidate;
                $user->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'is_admin']);
        });
    }
};
