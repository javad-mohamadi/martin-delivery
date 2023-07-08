<?php

namespace App\Http\Requests\Courier;

use App\Http\Requests\Abstracts\BaseRequest;

class GetCourierOrdersRequest extends BaseRequest
{
    protected array $access = [
        'roles'      => 'courier',
        'permission' => ''
    ];
}
