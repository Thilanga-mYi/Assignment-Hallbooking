<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_no',
        'date',
        'start_time',
        'end_time',
        'start_location',
        'end_location',
        'route_description',
        'remark',
        'status',
    ];

    const WEEK_DAYS = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];

    public static function laratablesStatus($transport)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($transport['status']) . '">' . self::$status[$transport['status']] . '</span>';
    }

    public static function laratablesCustomAction($transport)
    {
        return '<i onclick="doEdit(' . $transport['id'] . ')" class="la la-edit ml1 text-warning"></i>' .
            '<i onclick="doDelete(' . $transport['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['vehicle_no'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2]);
    }
}
