<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_name',
        'subject_id',
        'lecture_hall_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];
    public static function laratablesStatus($timetable)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($timetable['status']) . '">' . self::$status[$timetable['status']] . '</span>';
    }

    public static function laratablesCustomAction($timetable)
    {
        return '<i onclick="doEdit(' . $timetable['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $timetable['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['slot_name'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2]);
    }
}
