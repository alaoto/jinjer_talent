<?php

namespace App\Http\Controllers;
use App\Models\DataUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() {
        try {
            $columns = ['user_id', 'last_name', 'first_name', 'birthday', 'email', 'zipcode', 'prefcode', 'city', 'address1', 'tel'];
            // DataUsersモデルを使用してすべてのユーザーを取得
            $dataUsers = DataUsers::select($columns)->get();
            // JSON形式でデータを返す
            return response()->json($dataUsers, 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            // 403エラーを返す
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
