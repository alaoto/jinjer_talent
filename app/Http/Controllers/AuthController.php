<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUsers;
use App\Models\MasterAdmins;
use App\Models\DataAdmins;
use App\Models\DataUsers;

// ユーザーログイン
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

    // 管理者ログイン
    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('admin_name', 'password');

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['message' => '認証に失敗しました。ユーザIDまたはパスワードが正しくありません。'], 401);
        }

        $admin = Auth::guard('admin')->user();
        $token = $admin->createToken('admin-api-token')->plainTextToken;

        $adminDetails = $admin->adminDetails()->get();

        foreach ($adminDetails as $adminDetail) {
            $responseData = [
                'token' => $token,
                'user'  => [
                    'userId'         => $adminDetail->admin_id,
                    'lastName'       => $adminDetail->last_name,
                    'firstName'      => $adminDetail->first_name,
                    'email'          => $adminDetail->email,
                    'permissionCode' => $adminDetail->permission_code,
                ],
            ];
            break;
        }

        return response()->json($responseData, 200);
    }

    public function logoutAdmin(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Admin logged out successfully']);
    }
}
