<?php

namespace App\Services\Interfaces;

use App\DTOs\Courier\GetCourierOrdersDTO;
use App\DTOs\Courier\ShowCourierOrderDTO;
use App\DTOs\Courier\CreateCourierOrderDTO;
use App\DTOs\Courier\UpdateCourierOrderDTO;

interface CourierOrderServiceInterface
{
    public function getPendingOrders();

    public function index(GetCourierOrdersDTO $dto);

    public function show(ShowCourierOrderDTO $dto);

    public function acceptOrder(CreateCourierOrderDTO $dto);

    public function update(UpdateCourierOrderDTO $dto);
}
