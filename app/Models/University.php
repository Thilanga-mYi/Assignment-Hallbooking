<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'status'];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];

    public static function laratablesStatus($university)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($university['status']) . '">' . self::$status[$university['status']] . '</span>';
    }

    public static function laratablesCustomAction($university)
    {
        return '<i onclick="doEdit(' . $university['id'] . ')" class="la la-edit ml1 text-warning"></i>' .
            '<i onclick="doDelete(' . $university['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['name'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2]);
    }
}
