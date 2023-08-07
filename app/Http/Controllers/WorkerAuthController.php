<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Admin;
use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\WorkerStoreRequest;
use App\Services\WorkerService\WorkerAuthService\WorkerLoginService;
use App\Services\WorkerService\WorkerAuthService\WorkerRegisterService;
use Doctrine\Inflector\Rules\Word;

class WorkerAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:worker', ['except' => ['login', 'register', 'verify']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return (new WorkerLoginService())->login($request);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(WorkerStoreRequest $request)
    {
        return (new WorkerRegisterService)->register($request);
    }
    function verify($token)
    {
        $worker = Worker::whereVerificationToken($token)->first();
        if (!$worker) {
            return response()->json([
                "message" => "this token is invalid"
            ]);
        }
        $worker->verification_token = null;
        $worker->verified_at = now();
        $worker->save();
        return response()->json([
            "message" => "your account has been verified"
        ]);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('worker')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
}
