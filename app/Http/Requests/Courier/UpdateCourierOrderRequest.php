<?php

namespace App\Http\Requests\Courier;

use App\Enum\CourierOrderEnum;
use App\Http\Requests\Abstracts\BaseRequest;

class UpdateCourierOrderRequest extends BaseRequest
{

    protected array $access = [
        'roles'      => 'courier',
        'permission' => ''
    ];

    public function rules(): array
    {
        return [
            'id'     => 'required|exists:courier_orders,id',
            'status' => 'required|in:' . implode(',', CourierOrderEnum::allowStatusForUpdate()),
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
