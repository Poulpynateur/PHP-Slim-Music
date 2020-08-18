<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        $v = Validator::make($request->all(), [
            'username' => 'required',
            'password'  => 'required',
        ]);

        if ($v->fails())
        {
            return response()->json([
                'msg' => $v->errors()
            ], 422);
        }

        $credentials = $request->only('username', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['msg' => 'Success.'], 200)->header('Authorization', $token);
        }

        return response()->json(['msg' => 'Login error.'], 401);
    }

    public function logout() {
        $this->guard()->logout();

        return response()->json([
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function user(Request $request) {
        $user = User::find(Auth::user()->id);

        return response()->json($user);
    }

    public function refresh() {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['msg' => 'Successs.'], 200)
                ->header('Authorization', $token);
        }

        return response()->json(['msg' => 'Refresh token error.'], 401);
    }

    private function guard() {
        return Auth::guard();
    }
}