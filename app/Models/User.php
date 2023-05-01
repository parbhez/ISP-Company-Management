<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_admin',
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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function getPermissionGroups()
    {
      $temp = [];
      $final = [];
       $permission_groups = Permission::select('group_name')
            ->groupBy('group_name')
            ->get();

        foreach($permission_groups as $group){
            $temp[$group->group_name] = Permission::select('name', 'id')
            ->where('group_name', $group->group_name)
            ->get();
            $final = $temp;
        }

        return $final;
    }

     /**
     * Query Filter
     *
     * @param  QueryFilter $filters
     * @return Collection
     */

     public function scopeFilter($query, QueryFilter $filters)
     {
         return $filters->apply($query);
     }
}
