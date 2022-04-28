<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'usertype', 'status'];

    public function permissiondata()
    {
        return $this->hasMany(Permissions::class, 'usertype', 'id');
    }

    public function permissionandroutesdata()
    {
        return $this->hasMany(Permissions::class, 'usertype', 'id')->with('routedata');
    }

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];

    public static function laratablesStatus($usertype)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($usertype['status']) . '">' . self::$status[$usertype['status']] . '</span>';
    }

    public static function laratablesCustomAction($usertype)
    {
        return '<i onclick="doEdit(' . $usertype['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $usertype['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesCustomPermitted($usertype)
    {
        $cellData='';
        foreach ($usertype->permissionandroutesdata as $key => $value) {
            $cellData.='<small class="text-success">'.$value['routedata']->name.'</small><br>';
        }

        if(count($usertype->permissionandroutesdata)==0){
            $cellData='<small class="text-danger">No Permissions Assigned</small>';
        }

        return  $cellData;
    }

    public static function laratablesRoleRelationQuery()
    {
        return function ($query) {
            $query->with('permissionandroutesdata');
        };
    }

    public static function laratablesSearchableColumns()
    {
        return ['usertype'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2]);
    }
}
