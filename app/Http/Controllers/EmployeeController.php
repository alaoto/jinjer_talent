<?php

namespace App\Http\Controllers;
use App\Models\DataUsers;
use App\Models\MasterUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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

    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $validatedData = $request->validate([
                'user_name' => 'required',
                'password' => 'required',
                'user_id' => 'required',
                'last_name' => 'required',
                'first_name' => 'required',
                'birthday' => 'required',
                'email' => 'required',
                'zipcode' => 'required',
                'prefcode' => 'required',
                'city' => 'required',
                'address1' => 'required',
                'tel' => 'required',
            ]);
            // 新規データを登録する
            $masterUsers = MasterUsers::create([
                'user_name' => $validatedData['user_name'],
                'password' => Hash::make($validatedData['password']),
            ]);
            // このタイミングでMasterUsersがIDを何で登録したか分かりますか？
            DataUsers::create([
                'user_id' => $masterUsers->id,
                'last_name' => $validatedData['last_name'],
                'first_name' => $validatedData['first_name'],
                'birthday' => $validatedData['birthday'],
                'email' => $validatedData['email'],
                'zipcode' => $validatedData['zipcode'],
                'prefcode' => $validatedData['prefcode'],
                'city' => $validatedData['city'],
                'address1' => $validatedData['address1'],
                'tel' => $validatedData['tel'],
            ]);
            $responseData = [
                'user_name' => $validatedData['user_name'],
                'user_id' => $validatedData['user_id'],
                'last_name' => $validatedData['last_name'],
                'first_name' => $validatedData['first_name'],
                'birthday' => $validatedData['birthday'],
                'email' => $validatedData['email'],
                'zipcode' => $validatedData['zipcode'],
                'prefcode' => $validatedData['prefcode'],
                'city' => $validatedData['city'],
                'address1' => $validatedData['address1'],
                'tel' => $validatedData['tel'],
            ];
            DB::commit();
            // JSON形式でデータを返す
            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            // 403エラーを返す
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function update(Request $request, $id) {
        try {
            $request->validate([
                "last_name" => "required",
                "first_name" => "required",
                "birthday" => "required",
                "email" => "required",
                "zipcode" => "required",
                "prefcode" => "required",
                "city" => "required",
                "address1" => "required",
                "tel" => "required",
            ]);
            // レコードを検索する
            $dataUsers = DataUsers::findOrFail($id);
            // レコードを更新する
            $dataUsers->last_name = $request->last_name;
            $dataUsers->first_name = $request->first_name;
            $dataUsers->birthday = $request->birthday;
            $dataUsers->email = $request->email;
            $dataUsers->zipcode = $request->zipcode;
            $dataUsers->prefcode = $request->prefcode;
            $dataUsers->city = $request->city;
            $dataUsers->address1 = $request->address1;
            $dataUsers->tel = $request->tel;
            $dataUsers->save();
            // JSON形式でデータを返す
            return response()->json($dataUsers, 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            // 403エラーを返す
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            // レコードを検索する
            $dataUsers = DataUsers::where('user_id', $id)->firstOrFail();
            $masterUsers = MasterUsers::findOrFail($id);
            // レコードを削除する
            $dataUsers->delete();
            $masterUsers->delete();
            DB::commit();
            // JSON形式でデータを返す
            return response()->json(['user_id' => $dataUsers->user_id], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
            // 403エラーを返す
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
