<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class UpdateCompanyOrdersDTO
{
    public int $companyId;

    public int $orderId;

    public ?string $status;

    public function __construct(int $companyId, int $orderId, ?string $status)
    {
        $this->companyId = $companyId;
        $this->orderId   = $orderId;
        $this->status    = $status;
    }

    public static function getFromRequest(Request $request): UpdateCompanyOrdersDTO
    {
        return new static(
            $request->user()->id,
            $request->id,
            $request->status,
        );
    }
}
