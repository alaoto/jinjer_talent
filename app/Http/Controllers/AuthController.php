<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUsers;
use App\Models\MasterAdmins;

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        $credentials = $request->only('user_name', 'password');

        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::guard('web')->user();
        $token = $user->createToken('user-api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logoutUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'User logged out successfully']);
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('admin_name', 'password');

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['message' => 'ログイン認証に失敗しました。' . print_r(var_dump($credentials))], 401);
        }

        $admin = Auth::guard('admin')->user();
        $token = $admin->createToken('admin-api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logoutAdmin(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Admin logged out successfully']);
    }
}
