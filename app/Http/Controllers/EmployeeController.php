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
            $columns = ['user_id', 'last_name', 'first_name', 'birthday', 'email', 'zipcode', 'prefcode', 'city', 'address', 'tel'];

            // DataUsersモデルを使用してすべてのユーザーを取得
            $dataUsers = DataUsers::select($columns)->get();

            // JSON形式でデータを返す
            return response()->json($dataUsers, 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
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
                'address' => 'required',
                'tel' => 'required',
            ]);

            // 新規データを登録する
            $masterUsers = MasterUsers::create([
                'user_name' => $validatedData['user_name'],
                'password' => Hash::make($validatedData['password']),
            ]);
            DataUsers::create([
                'user_id' => $masterUsers->id,
                'last_name' => $validatedData['last_name'],
                'first_name' => $validatedData['first_name'],
                'birthday' => $validatedData['birthday'],
                'email' => $validatedData['email'],
                'zipcode' => $validatedData['zipcode'],
                'prefcode' => $validatedData['prefcode'],
                'city' => $validatedData['city'],
                'address' => $validatedData['address'],
                'tel' => $validatedData['tel'],
            ]);

            // レスポンスデータを作成する
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
                'address' => $validatedData['address'],
                'tel' => $validatedData['tel'],
            ];
            DB::commit();

            // JSON形式でデータを返す
            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
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
                "address" => "required",
                "tel" => "required",
            ]);

            // レコードを検索する
            $dataUsers = DataUsers::find($id);
            if (is_null($dataUsers)) {
                return response()->json(['error' => '指定されたIDの従業員が存在しません。'], 404);
            }
            $dataUsers = DataUsers::where('user_id', $id)->firstOrFail();

            // レコードを更新する
            $dataUsers->last_name = $request->last_name;
            $dataUsers->first_name = $request->first_name;
            $dataUsers->birthday = $request->birthday;
            $dataUsers->email = $request->email;
            $dataUsers->zipcode = $request->zipcode;
            $dataUsers->prefcode = $request->prefcode;
            $dataUsers->city = $request->city;
            $dataUsers->address = $request->address;
            $dataUsers->tel = $request->tel;
            $dataUsers->save();
            $responseData = [
                "user_id" => $dataUsers->user_id,
                "last_name" => $dataUsers->last_name,
                "first_name" => $dataUsers->first_name,
                "birthday" => $dataUsers->birthday,
                "email" => $dataUsers->email,
                "zipcode" => $dataUsers->zipcode,
                "prefcode" => $dataUsers->prefcode,
                "city" => $dataUsers->city,
                "address" => $dataUsers->address,
                "tel" => $dataUsers->tel
            ];

            // JSON形式でデータを返す
            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに記録
            Log::error($e->getMessage());
        }
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            // レコードを検索する
            $dataUsers = DataUsers::where('user_id', $id)->first();
            if (is_null($dataUsers)) {
                return response()->json(['error' => '指定されたIDの従業員が存在しません。'], 404);
            }
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
        }
    }
}
