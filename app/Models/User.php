<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nic',
        'name',
        'email',
        'password',
        'usertype',
        'status',
        'mobile',
        'license'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function laratablesStatus($user)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($user['status']) . '">' . self::$status[$user['status']] . '</span>';
    }

    public static function laratablesUsertype($user)
    {
        return '<span class="badge badge-danger">' . $user->usertypedata->usertype . '</span>';
    }

    public static function laratablesCustomAction($user)
    {
        return '<i onclick="doEdit(' . $user['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $user['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['email', 'name'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2]);
    }

    public static function laratablesRoleRelationQuery()
    {
        return function ($query) {
            $query->with('usertypedata');
        };
    }

    public function usertypedata()
    {
        return $this->hasOne(UserType::class, 'id', 'usertype');
    }
}
