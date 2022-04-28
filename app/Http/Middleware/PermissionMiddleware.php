<?php

namespace App\Http\Middleware;

use App\Models\Permissions;
use App\Models\Routes;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()['status'] == '1') {
            if ((new Permissions)->isValid($request->getPathInfo())) {
                return $next($request);
            } else {
                return abort(403, 'Not permitted to access.');
            }
        } else {
            return abort(401, (Auth::user()['status'] == '3') ? 'Your account has been blocked.' : 'Your account is inactive.');
        }
    }
}
