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
        ];
    }

    public function messages()
    {
        return [
            'name' => [
                'required' => 'Введите имя',
                'string' => 'Имя должно быть строкой',
            ],
            'lastname' => [
                'required' => 'Введите имя',
                'string' => 'Имя должно быть строкой',
            ],
        ];
    }
}
