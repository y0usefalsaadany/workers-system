<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AuthAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(AuthAdminRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        return $this->token($token);
    }

    public function register(AuthAdminRequest $request)
    {

        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return $this->token($token);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'token' => Auth::refresh(),
            'type' => 'bearer',
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function token($token)
    {
        return response()->json([
            'token' => $token,
            'type' => 'bearer',
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => auth()->user(),
        ]);
    }
}