<?php

namespace Workbench\App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

final class User extends AuthUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';
}
