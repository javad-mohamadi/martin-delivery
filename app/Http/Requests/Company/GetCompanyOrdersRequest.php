<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\Abstracts\BaseRequest;

class GetCompanyOrdersRequest extends BaseRequest
{
    protected array $access = [
        'roles'      => 'company',
        'permission' => ''
    ];
}
