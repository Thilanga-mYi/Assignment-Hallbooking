<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Routes extends Model
{
    use HasFactory;

    protected $fillable=['name','route'];

    public function getViaRoute($route)
    {
        return $this::where('route', $route)->first();
    }

    public function getAll()
    {
        return $this->orderBy('id', 'DESC')->get();
    }

    public function suggetions($input)
    {
        return $this::where([
            ["name", "LIKE", "%{$input['query']}%"],
        ])->get();
    }
}
