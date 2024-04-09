<?php

namespace App\Http\Controllers;
use App\Models\MasterAdmins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MasterAdminsController extends Controller
{
    public function readMasterAdmins()
    {
        try {
            // MasterAdminモデルを使用してすべての管理者を取得
            $admins = MasterAdmins::all();
            // JSON形式でデータを返す
            return response()->json($admins, 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            // 403エラーを返す
            return response()->json(['error' => 'Failed to read master admins'], 403);
        }
    }

    public function createMasterAdmin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'admin_name' => 'required',
                'password' => 'required',
            ]);
            // パスワードをハッシュ化する
            $validatedData['password'] = Hash::make($request->password);
            // 新規データを登録する
            $masterAdmin = MasterAdmins::create($validatedData);
            // JSON形式でデータを返す
            return response()->json($masterAdmin, 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            // 403エラーを返す
            return response()->json(['error' => 'Failed to create master admin'], 403);
        }
    }
}
