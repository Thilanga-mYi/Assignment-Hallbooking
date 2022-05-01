<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureHall extends Model
{
    use HasFactory;

    protected $fillable = [
        'lecture_hall_name',
        'university_id',
        'lecture_hall_location',
        'student_capacity',
        'description',
        'status',
    ];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];

    public static function laratablesStatus($lecture_hall)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($lecture_hall['status']) . '">' . self::$status[$lecture_hall['status']] . '</span>';
    }

    public static function laratablesCustomAction($lecture_hall)
    {
        return '<i onclick="doEdit(' . $lecture_hall['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $lecture_hall['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesAdditionalColumns()
    {
        return ['university_id'];
    }

    public static function laratablesUniversityId($lecture_hall){
        return $lecture_hall->name;
    }

    public static function laratablesSearchableColumns()
    {
        return ['lecture_hall_name'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2])->with('getUniversities');
    }

    public function getUniversities()
    {
        return $this->hasOne(University::class, 'id', 'university_id');
    }
}
