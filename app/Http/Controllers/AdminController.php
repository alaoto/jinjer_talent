<?php

namespace App\Http\Controllers;

use App\Models\DataAdmins;
use App\Models\MasterAdmins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;

class AdminController extends Controller
{
    public function index() {
        try {
            $columns = ['admin_id', 'permission_code', 'last_name', 'first_name', 'email'];

            // DataAdminsモデルを使用してすべてのユーザーを取得
            $dataAdmins = DataAdmins::select($columns)->get();

            // JSON形式でデータを返す
            return response()->json($dataAdmins, 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            return response()->json(['message' => '内部サーバーエラーが発生しました。'], 500);
        }
    }

    public function store(AdminRequest $request) {
        try {
            DB::beginTransaction();

            // 新規データを登録する
            $masterAdmins = MasterAdmins::create([
                'admin_name' => $request->admin_name,
                'password' => Hash::make($request->password),
            ]);
            DataAdmins::create([
                'admin_id' => $masterAdmins->id,
                'permission_code' => $request->permission_code,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'email' => $request->email,
            ]);

            // レスポンスデータを作成する
            $responseData = [
                'admin_id' => $masterAdmins->id,
                'permission_code' => $request->permission_code,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'email' => $request->email,
            ];
            DB::commit();

            // JSON形式でデータを返す
            return response()->json($responseData, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            return response()->json(['message' => '内部サーバーエラーが発生しました。'], 500);
        }
    }

    public function update(AdminRequest $request, $id) {
        try {
            // レコードを検索する
            $dataAdmins = DataAdmins::find($id);
            if (is_null($dataAdmins)) {
                return response()->json(['error' => '指定されたIDの管理者が存在しません。'], 404);
            }
            $dataAdmins = DataAdmins::where('admin_id', $id)->firstOrFail();

            // レコードを更新する
            $dataAdmins->permission_code = $request->permission_code;
            $dataAdmins->last_name = $request->last_name;
            $dataAdmins->first_name = $request->first_name;
            $dataAdmins->email = $request->email;
            $dataAdmins->save();
            $responseData = [
                "permission_code" => $dataAdmins->permission_code,
                "last_name" => $dataAdmins->last_name,
                "first_name" => $dataAdmins->first_name,
                "email" => $dataAdmins->email,
            ];

            // JSON形式でデータを返す
            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            return response()->json(['message' => '内部サーバーエラーが発生しました。'], 500);
        }
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            // レコードを検索する
            $dataAdmins = DataAdmins::where('admin_id', $id)->first();
            if (is_null($dataAdmins)) {
                return response()->json(['error' => '指定されたIDの管理者が存在しません。'], 404);
            }
            $masterAdmins = MasterAdmins::findOrFail($id);

            // レコードを削除する
            $dataAdmins->delete();
            $masterAdmins->delete();
            DB::commit();

            // JSON形式でデータを返す
            return response()->json(['admin_id' => $dataAdmins->admin_id], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            return response()->json(['message' => '内部サーバーエラーが発生しました。'], 500);
        }
    }
}