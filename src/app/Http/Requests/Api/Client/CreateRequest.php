<?php

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Api\BaseRequest;

class CreateRequest extends BaseRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|string',
            'lastname' => 'bail|required|string',
            'phones' => 'array|min:1',
            'phones.*' => 'array',
            'phones.*.phone' => 'bail|string|regex:/(\+)\d{11,13}/|unique:phones,phone',
            'emails' => 'array|min:1',
            'emails.*' => 'array',
            'emails.*.email' => 'email|unique:emails,email',
        ];
    }
}
