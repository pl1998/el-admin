<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    // Rest omitted for brevity
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'status',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get User Avatar.
     *
     * @return array|mixed|string
     */
    public function getAvatarAttribute()
    {
        $avatar = $this->attributes['avatar'];
        if ($avatar) {
            if (!URL::isValidUrl($avatar)) {
                $avatar = Storage::disk('public')->files($avatar);
            }
        } else {
            $avatar = asset(config('el_admin.logo'));
        }

        return $avatar;
    }

    /**
     * Get User Roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        $pivotTable = config('el_admin.database.user_roles_model');

        $relatedModel = config('el_admin.database.roles_model');

        return $this->belongsToMany($pivotTable, $relatedModel, 'user_id', 'role_id')->withTimestamps();
    }
}
