<?php

namespace App\Http\Requests\Courier;

use App\Http\Requests\Abstracts\BaseRequest;

class ShowCourierOrderRequest extends BaseRequest
{
    protected array $access = [
        'roles'      => 'courier',
        'permission' => ''
    ];

    public function rules()
    {
        return [
            'id' => 'required|exists:courier_orders,id'
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
