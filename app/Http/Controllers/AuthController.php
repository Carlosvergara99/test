<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;



class AuthController extends Controller
{
   /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
       $request->validate([
            'password' =>'required',
            'email' =>'required|email'
         ]);

         $credentials = $request->only(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED );
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {;
        return response()->json(auth()->user());
    }

    
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function register(Request $request){
        
        $request->validate([
           'name' =>'required',
           'email' =>'required|unique:users,email',
           'password' =>'required|min:6',
           'role' =>'required',
        ]);
      
        $data =$request->only(['name','email','password']);
        $user = new User($data);
        $user->save();
        if ($request->role == 1) {
            $user->assignRole('Admin');
        }else{
            $user->assignRole('vendedor');
        }

        return response()->json(['msg' => 'Registered Successfully']);
    }
    public function getPrmissions(Request $request)
    {
        $data  =  DB::table('model_has_roles')->where('model_id', $request->id)->get(['role_id']);
        return response()->json([
            'role' =>  $data 
        ]);
    }
}
