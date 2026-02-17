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

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role',
        'is_active',
        'permissions',
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
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'permissions' => 'array',
        ];
    }
    
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->is_admin;
    }
    
    public function isWorker(): bool
    {
        return $this->role === 'worker';
    }
    
    /**
     * Check if worker has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        // Admins have all permissions
        if ($this->isAdmin()) {
            return true;
        }
        
        // Workers check their permissions array
        if ($this->isWorker()) {
            $permissions = $this->permissions ?? [];
            return in_array($permission, $permissions);
        }
        
        return false;
    }
    
    /**
     * Get all available permissions for workers
     */
    public static function getAvailablePermissions(): array
    {
        return [
            'dashboard' => 'Kontrolna tabla',
            'products' => 'Interni Materijali',
            'work_orders' => 'Radni Nalozi',
            'inventory' => 'Dopuna Zaliha',
            'invoices' => 'Fakture',
            'activity_logs' => 'Dnevnik Aktivnosti',
        ];
    }
}
