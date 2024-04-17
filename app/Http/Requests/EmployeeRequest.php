<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class EmployeeRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                // storeメソッドの場合
                return [
                    'user_name' => 'required|max:100',
                    'password' => 'required|min:10',
                    'user_id' => 'max:20|unique:data_users',
                    'last_name' => 'required|max:50',
                    'first_name' => 'required|max:50',
                    'birthday' => 'required|date_format:Y-m-d',
                    'email' => 'required|email|max:255',
                    'zipcode' => 'required|regex:/^\d{7}$/',
                    'prefcode' => [
                        'required', 
                        'regex:/^(0[1-9]|[1-3][0-9]|4[0-7])$/'
                    ],
                    'city' => 'required|max:15',
                    'address' => 'required|max:150',
                    'tel' => [
                        'required', 
                        'regex:/^0[789]0-[0-9]{4}-[0-9]{4}$|^0([0-9]-[0-9]{4}|[0-9]{2}-[0-9]{3}|[0-9]{3}-[0-9]{2}|[0-9]{4}-[0-9])-[0-9]{4}$/'
                    ],
                ];

            case 'PUT':
                // updateメソッドの場合
                return [
                    'last_name' => 'required|max:50',
                    'first_name' => 'required|max:50',
                    'birthday' => 'required|date_format:Y-m-d',
                    'email' => 'required|email|max:255',
                    'zipcode' => 'required|regex:/^\d{7}$/',
                    'prefcode' => [
                        'required', 
                        'regex:/^(0[1-9]|[1-3][0-9]|4[0-7])$/'
                    ],
                    'city' => 'required|max:15',
                    'address' => 'required|max:150',
                    'tel' => [
                        'required', 
                        'regex:/^0[789]0-[0-9]{4}-[0-9]{4}$|^0([0-9]-[0-9]{4}|[0-9]{2}-[0-9]{3}|[0-9]{3}-[0-9]{2}|[0-9]{4}-[0-9])-[0-9]{4}$/'
                    ],
                ];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}