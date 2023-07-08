<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\Abstracts\BaseRequest;

class CreateCompanyOrderRequest extends BaseRequest
{
    protected $access = [
        'roles'       => 'company',
        'permissions' => '',
    ];

    public function rules(): array
    {
        return [
            'company_id'         => 'required',
            'provider_name'      => 'required|string',
            'provider_mobile'    => 'required|regex:/(09)[0-9]{9}/|digits:11',
            'provider_address'   => 'required|string',
            'provider_latitude'  => 'required|between:0,99.9999999',
            'provider_longitude' => 'required|between:0,99.9999999',
            'receiver_name'      => 'required|string',
            'receiver_mobile'    => 'required|regex:/(09)[0-9]{9}/|digits:11',
            'receiver_address'   => 'required|string',
            'receiver_latitude'  => 'required|between:0,99.9999999',
            'receiver_longitude' => 'required|between:0,99.9999999',
        ];
    }
}
