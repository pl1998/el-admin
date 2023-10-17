<?php

declare(strict_types=1);


namespace ElAdmin\LaravelVueAdmin\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class AdminUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
