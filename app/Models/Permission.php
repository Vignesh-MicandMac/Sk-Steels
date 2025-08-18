<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Permission extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['menu_slug', 'permission_type'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
