<?php

namespace App\Services\Interfaces;

use App\DTOs\Company\CreateCompanyOrdersDTO;
use App\DTOs\Company\GetCompanyOrdersDTO;
use App\DTOs\Company\ShowCompanyOrdersDTO;
use App\DTOs\Company\UpdateCompanyOrdersDTO;

interface CompanyOrderServiceInterface
{
    public function index(GetCompanyOrdersDTO $dto);

    public function show(ShowCompanyOrdersDTO $dto);

    public function create(CreateCompanyOrdersDTO $dto);

    public function update(UpdateCompanyOrdersDTO $dto);
}
