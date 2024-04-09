<?php

namespace App\Http\Controllers;
use App\Models\MasterAdmins;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MasterAdminsController extends Controller
{
    public function readMasterAdmins()
    {
        try {
        // MasterAdminモデルを使用してすべての管理者を取得します
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
}
