<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string email
 * @property Carbon|string|null $email_verified_at
 * @property string first_name
 * @property string last_name
 * @property string password
 * @property string remember_token
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const COLUMN_email = 'email';
    const COLUMN_email_verified_at = 'email_verified_at';
    const COLUMN_first_name = 'first_name';
    const COLUMN_last_name = 'last_name';
    const COLUMN_password = 'password';
    const COLUMN_remember_token = 'remember_token';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_first_name,
        self::COLUMN_last_name,
        self::COLUMN_email,
        self::COLUMN_password,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::COLUMN_password,
        self::COLUMN_remember_token,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::COLUMN_email_verified_at => 'datetime',
    ];

    static function getRules()
    {
        return [
            User::COLUMN_first_name => ['required', 'string', 'max:255'],
            User::COLUMN_last_name => ['required', 'string', 'max:255'],
            User::COLUMN_email => ['required', 'string', 'email', 'max:255', 'unique:users'],
            User::COLUMN_password => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
