<?php

namespace App\Http\Controllers\API;

use App\Models\DataUser;
use App\Models\MasterUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $dataUsers = DataUser::all();
            $response = $dataUsers->map(function ($dataUser) {
                return [
                    'user_id' => $dataUser->user_id,
                    'last_name' => $dataUser->last_name,
                    'first_name' => $dataUser->first_name,
                    'birthday' => $dataUser->birthday,
                    'email' => $dataUser->email,
                    'zipcode' => $dataUser->zipcode,
                    'prefcode' => $dataUser->prefcode,
                    'city' => $dataUser->city,
                    'address1' => $dataUser->address1,
                    'tel' => $dataUser->tel,
                ];
            });
            return response()->json($response);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => '内部サーバーエラーが発生しました。'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $masterUser = MasterUser::create([
                // 'id' => $request->input('id'),
                 'user_name' => $request->input('user_name'),
                 'password' => $request->input('password'),
                 // 'created_at' => $request->input('created_at'),
                 // 'updated_at' => $request->input('updated_at'),
             ]);
     
             $masterUserId = $masterUser->id;
     
             $dataUser = DataUser::create([
                // 'id' => $request->input('id'),,
                 'user_id' => $masterUserId, // master_users から取得した id
                 //'user_name' => $request->input('user_name'),
                 'last_name' => $request->input('last_name'),
                 'first_name' => $request->input('first_name'),
                 'birthday' => $request->input('birthday'),
                 'email' => $request->input('email'),
                 'nickname' => $request->input('nickname'),
                 'zipcode' => $request->input('zipcode'),
                 'prefcode' => $request->input('prefcode'),
                 'city' => $request->input('city'),
                 'address1' => $request->input('address1'),
                 'tel' => $request->input('tel'),
                 // 'created_at' => $request->input('created_at'),
                 // 'updated_at' => $request->input('updated_at'),
                 // 'deleted_at' => $request->input('deleted_at'),
             ]);

            return response()->json([
                'user_id' => $dataUser->user_id,
                'last_name' => $dataUser->last_name,
                'first_name' => $dataUser->first_name,
                'birthday' => $dataUser->birthday,
                'email' => $dataUser->email,
                'nickname' => $dataUser->nickname,
                'zipcode' => $dataUser->zipcode,
                'prefcode' => $dataUser->prefcode,
                'city' => $dataUser->city,
                'address1' => $dataUser->address1,
                'tel' => $dataUser->tel,
            ], 201);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => '内部サーバーエラーが発生しました。'], 500);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DataUser $dataUser
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataUser = DataUser::find($id);
        return response()->json($dataUser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DataUser $dataUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $dataUser = DataUser::find($id);
            if ($dataUser) {
                $dataUser->update([
                'last_name' => $request->input('last_name'),
                'first_name' => $request->input('first_name'),
                'birthday' => $request->input('birthday'),
                'email' => $request->input('email'),
                'nickname' => $request->input('nickname'),
                'zipcode' => $request->input('zipcode'),
                'prefcode' => $request->input('prefcode'),
                'city' => $request->input('city'),
                'address1' => $request->input('address1'),
                'tel' => $request->input('tel'),
            ]);

            return response()->json([
                'user_id' => $dataUser->user_id,
                'last_name' => $dataUser->last_name,
                'first_name' => $dataUser->first_name,
                'birthday' => $dataUser->birthday,
                'email' => $dataUser->email,
                'nickname' => $dataUser->nickname,
                'zipcode' => $dataUser->zipcode,
                'prefcode' => $dataUser->prefcode,
                'city' => $dataUser->city,
                'address1' => $dataUser->address1,
                'tel' => $dataUser->tel,
            ], 201);

            } else {
                // データが見つからない場合
                return response()->json(['error' => '指定されたIDの従業員が存在しません。'], 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => '内部サーバーエラーが発生しました。'], 500);
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DataUser $dataUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $dataUser = DataUser::find($id);
            // $dataUser->delete();
            // return response()->json(null, 204);
            if ($dataUser) {
                $dataUser->delete();
                return response()->json(null, 204);
            } else {
                // データが見つからない場合
                return response()->json(['error' => '指定されたIDの従業員が存在しません。'], 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => '内部サーバーエラーが発生しました。'], 500);
        }
    }
}