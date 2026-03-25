<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMINISTRATOR = 'Administrator';
    public const ROLE_REISADVISEUR = 'Reisadviseur';
    public const ROLE_FINANCIEEL_MEDEWERKER = 'Financieel Medewerker';
    public const ROLE_MANAGER = 'Manager';

    public const ROLES = [
        self::ROLE_ADMINISTRATOR,
        self::ROLE_REISADVISEUR,
        self::ROLE_FINANCIEEL_MEDEWERKER,
        self::ROLE_MANAGER,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canViewAccountOverview(): bool
    {
        return in_array($this->role, [self::ROLE_ADMINISTRATOR, self::ROLE_MANAGER], true);
    }

    public function canManageDashboard(): bool
    {
        return in_array(
            $this->role,
            [self::ROLE_ADMINISTRATOR, self::ROLE_MANAGER, self::ROLE_FINANCIEEL_MEDEWERKER],
            true
        );
    }
}
