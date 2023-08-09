<?php

namespace App\Http\Requests\Carrgo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCarrgoRequest extends FormRequest
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
                'iban' => 'string',
                'first_name' => 'string',
                'last_name' => 'string',
                'car_type_id' => 'required|integer',
                'details' => 'required|object',
                'details.cargo_type' => 'string',
                'details.weight' => 'string',
                'details.weight_type' => 'string',
                'details.width' => 'string',
                'details.height' => 'string',
                'details.length' => 'string',
                'details.trailer_type_id' => 'required|integer',
                'routes' => 'required|object',
                'routes.from' => 'required|object',
                'routes.to' => 'required|object'
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
            'details.required' => 'Carrgo details are required!',
            'routes.required' => 'Carrgo routes are required!',
            'details.trailer_type_id.required' => 'Trailer type is required!'
        ];
    }
}
