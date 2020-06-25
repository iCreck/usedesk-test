<?php

namespace App\Http\Requests\Api\Client;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseRequest
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
        $client = $this->route('client');
        return [
            'name' => 'string',
            'lastname' => 'string',
            'phones' => 'array',
            'phones.*' => function ($attribute, $value, $fail) use ($client) {
                $validator = $this->validatePhone($value, $client);
                if ($validator->fails()) {
                    $fail('Error while phones validation: ' . implode(' | ', $validator->errors()->all()));
                }
                return true;
            },
            'emails' => 'array|min:1',
            'emails.*' => function ($attribute, $value, $fail) use ($client) {
                $validator = $this->validateEmail($value, $client);
                if ($validator->fails()) {
                    $fail('Error while emails validation: ' . implode(' | ', $validator->errors()->all()));
                }
                return true;
            },
        ];
    }

    private function validatePhone($phone, $client)
    {
        $id = array_key_exists('id', $phone) ? $phone['id'] : null;
        return Validator::make($phone, [
            'id' => [
                'integer',
                'nullable',
                function ($attribute, $value, $fail) use ($client) {
                    if ($client->phones->where('id', $value)->count() === 0) {
                        $fail(sprintf('Id %d of phone doesn\'t belongs to this client', $value));
                    }
                    return true;
                },
            ],
            'phone' => ['regex:/(\+)\d{11,13}/', Rule::unique('phones', 'phone')->ignore($id)],
        ]);
    }

    private function validateEmail($email, $client)
    {
        $id = array_key_exists('id', $email) ? $email['id'] : null;
        return Validator::make($email, [
            'id' => [
                'integer',
                'nullable',
                function ($attribute, $value, $fail) use ($client) {
                    if ($client->emails->where('id', $value)->count() === 0) {
                        $fail(sprintf('Id %d of email doesn\'t belongs to this client', $value));
                    }
                    return true;
                },
            ],
            'email' => ['email', Rule::unique('emails', 'email')->ignore($id)],
        ]);
    }
}
