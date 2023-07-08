<?php

namespace App\Http\Requests\Courier;

use App\Http\Requests\Abstracts\BaseRequest;

class AcceptCourierOrderRequest extends BaseRequest
{
    protected array $access = [
        'roles'      => 'courier',
        'permission' => ''
    ];

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
        ];
    }
}
