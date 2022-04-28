<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable=['title','description','start','end','status'];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];

    public static function laratablesStatus($event)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($event['status']) . '">' . self::$status[$event['status']] . '</span>';
    }

    public static function laratablesCustomAction($event)
    {
        return '<i onclick="doEdit(' . $event['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $event['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['title'];
    }

    public static function laratablesQueryConditions($query)
    {
        return $query->whereIn('status', [1, 2]);
    }
}
