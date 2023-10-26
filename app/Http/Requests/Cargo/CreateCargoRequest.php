<?php

namespace App\Http\Requests\Cargo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCargoRequest extends FormRequest
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
                'date' => 'string',
                'car_type_id' => 'required|integer',

                'details' => 'required|object',
                'details.weight' => 'string',
                'details.weight_type' => 'string',
                'details.width' => 'string',
                'details.height' => 'string',
                'details.length' => 'string',
                'details.degree' => 'string',
                'details.packaging_type_id' => 'integer',
                'details.danger_status_id' => 'integer',

                'routes' => 'required|object',
                'routes.from' => 'required|object',
                'routes.to' => 'required|object',

                'contacts' => 'array',
                'contacts.*.id' => 'integer',
                'contacts.*.phone_number' => 'string',
                'contacts.*.email' => 'string|email',
                'contacts.*.first_name' => 'string',
                'contacts.*.last_name' => 'string',
                'contacts.*.private_number' => 'string',
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
            'car_type_id.required' => 'Car type is required!',
            'details.required' => 'Cargo details are required!',
            'routes.required' => 'Cargo routes are required!',
            'details.trailer_type_id.required' => 'Trailer type is required!'
        ];
    }
}
