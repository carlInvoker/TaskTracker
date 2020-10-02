<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use App\Http\Controllers\Controller;


class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function getUserData(Request $request)
     {
          $response = ["user" => $request->user('api')];
          return response($response, 200);
     }


     public function updateUserData(Request $request)
     {
         $validator = Validator::make($request->all(), [
           'first_name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'email' => 'required|email',
           'password' => 'required|string|max:1024',
         ]);
         if ($validator->fails())
         {
            return response(['errors'=>$validator->errors()->all()], 422);
         }
         $user = User::where('email', $request->user('api')->email)->first();

         $user->first_name = $request->first_name;
         $user->last_name = $request->last_name;
         $user->email = $request->email;
         $user->password = Hash::make($request->password);
         $user->save();

         $response = ["message" => 'user data updated'];
         return response($response, 200);
     }


     public function deleteUser(Request $request)
     {
         $user = User::where('email', $request->user('api')->email)->first();
         $token = $request->user()->token();
         $token->revoke();
         $user->delete();

         $response = ['message' => 'user deleted'];
         return response($response, 200);
     }


     public function getUsers()
     {
         $users = User::paginate(10);
         $response = ['users' => $users];
         return response($response, 200);
     }
}
