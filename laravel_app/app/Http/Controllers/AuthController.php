<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(SignUpRequest $request)
    {
        if (User::count() === 0) {
            $user = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken('kenkoku', ['*'], now()->addDays(7))->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }
        return response()->json([
            'message' => '既に管理者が存在しています',
        ], 400);
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('name', $request->name)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => '名前またはパスワードが間違っています',
            ], 401);
        }
        $token = $user->createToken('kenkoku', ['*'], now()->addDays(7))->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'ログアウトしました',
        ]);
    }
}
