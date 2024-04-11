<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUser;
use App\Models\MasterAdmin;
use Illuminate\Support\Facades\Log;

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
        try {
            // リクエストデータの 'loginId' を 'admin_name' に変更
            $request->merge(['admin_name' => $request->input('loginId')]);

            $credentials = $request->only('admin_name', 'password');

            // loginIdが存在するかを確認
            $admin = MasterAdmin::where('admin_name', $credentials['admin_name'])->first();

            if (!$admin) {
                // loginIdが存在しない場合
                return response()->json(['message' => '指定されたIDの従業員が存在しません。'], 404);
            }

            if (!Auth::guard('admin')->attempt($credentials)) {
                return response()->json(['message' => '認証に失敗しました。ユーザIDまたはパスワードが正しくありません。' . print_r(var_dump($credentials))], 401);
            }

            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('admin-api-token')->plainTextToken;

            $dataAdmin = $admin->adminDetails; 
            $response = [
                'user_id' => $dataAdmin->admin_id,
                'last_name' => $dataAdmin->last_name,
                'first_name' => $dataAdmin->first_name,
                'email' => $dataAdmin->email,
                'permission_code' => $dataAdmin->permission_code,
            ];
            return response()->json(['token' => $token, 'user' => $response], 200);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => '内部サーバーエラーが発生しました。'], 500);
        }
    }

    public function logoutAdmin(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Admin logged out successfully']);
    }
}
