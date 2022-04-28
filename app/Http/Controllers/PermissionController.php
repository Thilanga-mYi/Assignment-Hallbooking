<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use App\Models\Routes;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    public function index($term = null)
    {
        $data = [
            'usertypes' => (new UserType)->getUserTypes(),
            'routes' => (new Routes)->getAll(),
        ];

        return view('dashboard.pages.permissions')->with('data', $data);
    }

    public function editStatus($id, $status)
    {
        return (new UserType())->edit($id, ['status' => ($status == 2) ? 1 : 2], ['view' => Session::get('view', 'non'), 'activity' => 'Status Updated']);
    }

    public function find($id)
    {
        return (new UserType)->findFirst($id);
    }
}
