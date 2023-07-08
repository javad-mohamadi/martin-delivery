<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\Abstracts\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ShowCompanyOrderRequest extends BaseRequest
{
    protected $access = [
        'roles'       => 'company',
        'permissions' => '',
    ];

    public function rules()
    {
        return [
            'id'         => 'required|exists:orders,id',
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
