<?php

namespace App\Http\Requests\Deal;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MakeOfferRequest extends FormRequest
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
                'price' => 'integer|required',
                'deal_id' => 'integer|required',
                'driver_id' => 'integer|required',
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
            'price.required' => 'Price is required!',
            'price.integer' => 'Price must be integer!',
            'deal_id.required' => 'Deal id is required!',
            'deal_id.integer' => 'Deal id must be integer!',
            'driver_id.required' => 'Driver id is required!',
            'driver_id.integer' => 'Driver id must be integer!',
        ];
    }
}
