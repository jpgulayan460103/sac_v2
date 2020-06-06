<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validatedData = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('password','username');
        if(!auth()->attempt($credentials)){
            return response([
                'message' => 'Invalid credentials'
            ],422);
        }
        $user = User::whereUsername($request->username)->first();

        $createdToken = $this->getToken($request);
        return response([
            'user' => $user,
            'createdToken' => $createdToken
        ]);
    }

    public function getToken(Request $request)
    {
        $http = new \GuzzleHttp\Client;
        $oauth = DB::table('oauth_clients')->where('id',2)->first();

        $response = $http->post(config('services.passport.login_endpoint'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => 2,
                'client_secret' => $oauth->secret,
                'username' => $request->username,
                'password' => $request->password,
            ]
        ]);
        $login_response = json_decode((string)$response->getBody(), true);
        return $login_response;
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }
        return response([
            'status' => 'logged out',
        ]);
    }
}
