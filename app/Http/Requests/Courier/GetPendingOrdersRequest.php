<?php

namespace App\Http\Requests\Courier;

use App\Http\Requests\Abstracts\BaseRequest;

class GetPendingOrdersRequest extends BaseRequest
{
    protected array $access = [
        'roles'      => 'courier',
        'permission' => ''
    ];
}
