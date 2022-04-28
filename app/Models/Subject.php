<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];

    public static function laratablesStatus($subject)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($subject['status']) . '">' . self::$status[$subject['status']] . '</span>';
    }

    public static function laratablesCustomAction($subject)
    {
        return '<i onclick="doEdit(' . $subject['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $subject['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['email', 'name'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2]);
    }
}
