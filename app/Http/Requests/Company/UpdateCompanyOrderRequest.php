<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\Abstracts\BaseRequest;

class UpdateCompanyOrderRequest extends BaseRequest
{

    protected array $access = [
        'roles'      => 'company',
        'permission' => ''
    ];

    public function rules(): array
    {
        return [
            'id'         => 'required|exists:orders,id',
            'status'     => 'in:canceled',
            'company_id' => 'required',

        ];
    }

    public function prepareForValidation()
    {
        $id = $this->route('id');
        $this->merge(
            [
                'id' => $id,
            ]);
    }
}
