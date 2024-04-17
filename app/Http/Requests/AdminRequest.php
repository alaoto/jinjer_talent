<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                // storeメソッドの場合
                return [
                    'admin_name' => 'required|max:100',
                    'password' => 'required|min:10',
                    'admin_id' => 'max:20|unique:data_admins',
                    'permission_code' => 'required|max:30',
                    'last_name' => 'required|max:50',
                    'first_name' => 'required|max:50',
                    'email' => 'required|email|unique:data_admins|max:255',
                ];

            case 'PUT':
                // updateメソッドの場合
                return [
                    'permission_code' => 'required|max:30',
                    'last_name' => 'required|max:50',
                    'first_name' => 'required|max:50',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('data_admins')->ignore($this->id),
                    ],
                ];
        }
    }

    public function messages()
    {
        return [
            'admin_id.unique' => '指定されたユーザIDまたはメールアドレスの管理者がすでに存在します。',
            'email.unique' => '指定されたユーザIDまたはメールアドレスの管理者がすでに存在します。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }


}