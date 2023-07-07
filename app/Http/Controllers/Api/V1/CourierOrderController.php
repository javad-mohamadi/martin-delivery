<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CompanyOrderServiceInterface;

class CourierOrderController extends Controller
{
    /**
     * @param CompanyOrderServiceInterface $service
     */
    public function __construct(protected CompanyOrderServiceInterface $service)
    {
    }

}
