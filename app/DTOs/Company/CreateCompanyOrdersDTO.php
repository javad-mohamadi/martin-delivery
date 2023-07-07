<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class CreateCompanyOrdersDTO
{
    public $companyId;

    public $data;

    public function __construct(int $companyId, array $data)
    {
        $this->companyId = $companyId;
        $this->data      = $data;
    }

    public static function getFromRequest(Request $request): CreateCompanyOrdersDTO
    {
        return new static($request->user()->id, $request->validated());
    }
}
