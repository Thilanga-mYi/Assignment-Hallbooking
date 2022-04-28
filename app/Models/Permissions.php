<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Permissions extends Model
{
    use HasFactory;

    protected $fillable = ['route', 'usertype'];

    public function getPermissions($usertype)
    {
        return $this::where('usertype', $usertype)->with('routedata')->get();
    }

    public function isValid($route)
    {
        $route = (new Routes)->getViaRoute($route);

        if ($route) {
            if (!Session::has('routes')) {
                $validRouteIds = [];
                $validRoutes = [];

                foreach ($this->getPermissions(Auth::user()->usertype) as $key => $value) {
                    $validRouteIds[] = $value['routedata']['id'];
                    $validRoutes[] = '/' . $value['routedata']['route'];
                }

                Session::put('routeids', $validRouteIds);
                Session::put('routes', $validRoutes);
            }

            $isPermitted = false;
            
            if (UserType::where('status', 1)->where('id', Auth::user()->usertype)->first()) {
                if ($route) {
                    $isPermitted = $this->where('usertype', Auth::user()->usertype)->where('route', $route->id)->first();
                    if ($isPermitted) {
                        Session::put('view-route', $route->route);
                        Session::put('view', $route->name);

                        $isPermitted = true;
                    } else {
                        $isPermitted = false;
                    }
                }
            }
            return $isPermitted;
        }

        return false;
    }

    public function routedata()
    {
        return $this->hasOne(Routes::class, 'id', 'route');
    }

    public function route()
    {
        return $this->hasMany(Route::class, 'id', 'route');
    }

    public function createPermission($data, $activity)
    {
        return $this->create($data);
    }

    public function removeRecords($usertype, $activity)
    {
        return $this::where('usertype', $usertype)->delete();
    }
}
