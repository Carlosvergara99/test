<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{   
    public function getUsers()
    {
        $user =User::with('roles')->OrderBy('id', 'DESC')->get();
        return response()->json($user);

    }
    public function UpdateUsers(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'email' =>'required|unique:users,email,'.$request->id,
            'roleid' =>'required',
         ]);
        $user = User::findOrFail($request->id);
        if ($request->password !='') {
            $user->update($request->all('name','email','password'));
        }else{
            $user->update($request->all('name','email'));
        }
        $rol = DB::table('model_has_roles')->where('model_id', $request->id)->where('role_id',$request->roleid)->exists();
        if (!$rol) {
            DB::table('model_has_roles')->where('model_id',$request->id)->delete();
            if ($request->roleid == 2) {
                $user->assignRole('Admin');
            }else{
                $user->assignRole('vendedor');
            }
        }
        return response()->json($user);

    }
    public function destroy(Request $request )
    {
        DB::table('model_has_roles')->where('model_id',$request->id)->delete();
        $user = User::find($request->id);
        $user->delete();
    }
}
