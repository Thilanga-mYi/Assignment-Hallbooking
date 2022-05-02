<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lecture_category_id',
        'lecture_hall_id',
        'lecture_type',
        'day',
        'conduct_date',
        'start_time',
        'end_time',
        'student_capacity',
        'status',
    ];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];
    public static $lecture_type = [1 => 'Theory', 2 => 'Practicles'];

    public static function laratablesStatus($lecture)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($lecture['status']) . '">' . self::$status[$lecture['status']] . '</span>';
    }

    // public static function laratablesCustomViewenrolled($lecture)
    // {
    //     return '<i onclick="doViewEnreolledStudents(' . $lecture['id'] . ')" class="la la-eye ml1 text-primary"></i>';
    // }

    public static function laratablesCustomAction($lecture)
    {
        return '<i onclick="doViewEnreolledStudents(' . $lecture['id'] . ')" class="la la-eye ml1 pr-2 text-primary"></i>' .
            '<i onclick="doEdit(' . $lecture['id'] . ')" class="la la-edit ml1 text-warning">' .
            '</i>' .
            '<i onclick="doDelete(' . $lecture['id'] . ')" class="la la-trash ml-1 text-danger">' .
            '</i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['lecture_hall_name'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2]);
    }
}
