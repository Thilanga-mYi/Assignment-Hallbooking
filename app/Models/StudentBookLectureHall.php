<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentBookLectureHall extends Model
{
    use HasFactory;

    protected $fillable = [
        'reason',
        'student_id',
        'lecture_hall_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];
    public static function laratablesStatus($studentBookLactureHall)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($studentBookLactureHall['status']) . '">' . self::$status[$studentBookLactureHall['status']] . '</span>';
    }

    public static function laratablesCustomAction($studentBookLactureHall)
    {
        return $studentBookLactureHall['status'] != 1 ? '<i onclick="doConfirm(' . $studentBookLactureHall['id'] . ')" class="la la-check ml1 text-success"></i>' :
            ' <i onclick="doCancel(' . $studentBookLactureHall['id'] . ')" class="la la-times ml1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['reason'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2, 3]);
    }
}
