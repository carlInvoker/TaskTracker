<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use App\Http\Controllers\Controller;


class AuthController extends Controller
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

     public function register(Request $request)
     {
      $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'required|string|max:1024',
      ]);
      if ($validator->fails())
      {
         return response(['errors'=>$validator->errors()->all()], 422);
      }
      $user = new User;
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->email = $request->email;
      $user->password = Hash::make($request->password);
      $user->remember_token = Str::random(10);
      $user->save();

      $token = $user->createToken('Access Granted')->accessToken;
      $response = ['token' => $token];
      return response($response, 200);
     }

     public function login (Request $request) {
        $validator = Validator::make($request->all(), [
          'email' => 'required|string|email|max:255',
          'password' => 'required|string|max:1024',
        ]);
        if ($validator->fails())
        {
          return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
          if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Access Granted')->accessToken;
            $response = ['token' => $token];
            return response($response, 200);
          }
          else {
            $response = ["message" => "Wrong password"];
            return response($response, 422);
          }
        } else {
          $response = ["message" =>'User not found'];
          return response($response, 422);
        }
    }

    public function logout (Request $request) {
      $token = $request->user()->token();
      $token->revoke();
      $response = ['message' => 'Logged out!'];
      return response($response, 200);
    }

}
