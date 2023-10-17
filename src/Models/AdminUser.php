<?php

declare(strict_types=1);


namespace ElAdmin\LaravelVueAdmin\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class AdminUser extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
}
