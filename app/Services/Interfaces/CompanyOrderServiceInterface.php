<?php

namespace App\Services\Interfaces;

use App\DTOs\Company\GetCompanyOrdersDTO;
use App\DTOs\Company\ShowCompanyOrderDTO;
use App\DTOs\Company\CreateCompanyOrderDTO;
use App\DTOs\Company\UpdateCompanyOrderDTO;

interface CompanyOrderServiceInterface
{
    public function index(GetCompanyOrdersDTO $dto);

    public function show(ShowCompanyOrderDTO $dto);

    public function find(int $id);

    public function create(CreateCompanyOrderDTO $dto);

    public function update(UpdateCompanyOrderDTO $dto);

    public function getPendingOrders();

    public function updateOrderStatus($orderId, $status);

}
