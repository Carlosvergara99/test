<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function getUsers()
    {
        $user =User::OrderBy('id', 'DESC')->get();
        foreach ($user as $key => $value) {
            $data =DB::table('model_has_roles')->join('roles','model_has_roles.role_id','=','roles.id')->where('model_id', $value->id)->pluck('roles.name');
            $user[$key]->rol .= $data[0];

        }
        return response()->json($user);

    }
}
