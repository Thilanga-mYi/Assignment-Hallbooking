<?php

namespace App\Http\Controllers;

use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RouteController extends Controller
{
    public function suggetions(Request $request)
    {
        $data = array();
        $query = Routes::where('type', 1)->whereIn('id', Session::get('routeids', []));
        $term = $request->all()['query'];
        $query->where(function ($query) use ($term) {
            $query->where('name', "%{$term}%");
            $query->orWhere('route', 'LIKE', "%{$term}%");
        });

        foreach ($query->get() as $value) {
            $data[] = [
                'id' => $value->route,
                'name' =>  $value->name,
            ];
        }

        return response()->json($data, 200);
    }
}
