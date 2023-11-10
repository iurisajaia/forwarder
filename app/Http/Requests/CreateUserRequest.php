<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'id' => 'integer',
            'name' => 'string',
            'personal_number',
            'phone' => 'required|string',
            'email' => 'string',
            'user_role_id' => 'integer',
            'images' => '',
            'languages' => 'array',
            'languages.*' => 'integer',
            'location' => 'array'
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success' => false,

            'message' => 'Validation errors',

            'data' => $validator->errors()->messages()

        ], 500));

    }

    public function messages()
    {
        return [
            'phone.required' => 'Phone is required!'
        ];
    }
}
