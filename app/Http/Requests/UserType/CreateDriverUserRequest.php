<?php

namespace App\Http\Requests\UserType;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateDriverUserRequest extends FormRequest
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
                'telegram' => 'string',
                'whatsapp' => 'string',
                'viber' => 'string',
                'referral_code' => 'string',
                'iban' => 'string',
                'car' => 'nullable|array',
                'trailer' => 'nullable|array',
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success' => false,

            'message' => 'Validation errors',

            'data' => $validator->errors()->messages()

        ]));

    }

    public function messages()
    {
        return [
        ];
    }
}
