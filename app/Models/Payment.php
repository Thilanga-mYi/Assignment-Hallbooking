<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_id',
        'lecture_id',
        'paid_amount',
        'remark',
        'status',
    ];

    public static $status = [1 => 'Approved', 2 => 'Rejected', 3 => 'Blocked', 4 => 'Deleted'];

    public static function laratablesStatus($payment)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($payment['status']) . '">' . self::$status[$payment['status']] . '</span>';
    }

    public static function laratablesCustomAction($payment)
    {
        return '<i onclick="doEdit(' . $payment['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $payment['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
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
