<?php

namespace App\Http\Requests\Car;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCarRequest extends FormRequest
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
            [
                'id' => 'integer',
                'number' => 'string',
                'title' => 'string',
                'model' => 'string',
                'identification_number' => 'string',
                'car_type_id' => 'integer',
                'images' => 'array',
                'images.*.uri' => 'nullable|file|mimes:jpeg,png,gif,pdf',
                'images.*.title' => 'string'
            ]
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()->messages()

        ]));

    }

    public function messages()
    {
        return [
        ];
    }
}
