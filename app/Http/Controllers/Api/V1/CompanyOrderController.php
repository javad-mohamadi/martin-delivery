<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\DTOs\Company\GetCompanyOrdersDTO;
use App\DTOs\Company\ShowCompanyOrdersDTO;
use App\DTOs\Company\UpdateCompanyOrdersDTO;
use App\Http\Resources\CompanyOrderResource;
use App\DTOs\Company\CreateCompanyOrdersDTO;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Company\GetCompanyOrdersRequest;
use App\Http\Requests\Company\ShowCompanyOrderRequest;
use App\Http\Requests\Company\CreateCompanyOrderRequest;
use App\Http\Requests\Company\UpdateCompanyOrderRequest;
use App\Services\Interfaces\CompanyOrderServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyOrderController extends Controller
{
    /**
     * @param CompanyOrderServiceInterface $companyOrderService
     */
    public function __construct(protected CompanyOrderServiceInterface $companyOrderService)
    {
    }

    /**
     * @param GetCompanyOrdersRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetCompanyOrdersRequest $request): AnonymousResourceCollection
    {
        $dto    = GetCompanyOrdersDTO::getFromRequest($request);
        $orders = $this->companyOrderService->index($dto);

        return CompanyOrderResource::collection($orders);
    }

    /**
     * @param ShowCompanyOrderRequest $request
     * @return CompanyOrderResource
     */
    public function show(ShowCompanyOrderRequest $request): CompanyOrderResource
    {
        $dto   = ShowCompanyOrdersDTO::getFromRequest($request);
        $order = $this->companyOrderService->show($dto);

        return new CompanyOrderResource($order);
    }

    /**
     * @param CreateCompanyOrderRequest $request
     * @return CompanyOrderResource
     */
    public function create(CreateCompanyOrderRequest $request): CompanyOrderResource
    {
        $dto   = CreateCompanyOrdersDTO::getFromRequest($request);
        $order = $this->companyOrderService->create($dto);

        return new CompanyOrderResource($order);
    }

    /**
     * @param UpdateCompanyOrderRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCompanyOrderRequest $request): JsonResponse
    {
        $dto = UpdateCompanyOrdersDTO::getFromRequest($request);
        $this->companyOrderService->update($dto);

        return response()->json([
                                    'message' => "your request was successful",
                                ], Response::HTTP_OK);
    }

}
