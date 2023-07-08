<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\DTOs\Company\GetCompanyOrdersDTO;
use App\DTOs\Company\ShowCompanyOrderDTO;
use App\DTOs\Company\UpdateCompanyOrderDTO;
use App\DTOs\Company\CreateCompanyOrderDTO;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Company\GetCompanyOrdersRequest;
use App\Http\Requests\Company\ShowCompanyOrderRequest;
use App\Http\Resources\Company\ShowCompanyOrderResource;
use App\Http\Resources\Company\GetCompanyOrdersResource;
use App\Http\Requests\Company\CreateCompanyOrderRequest;
use App\Http\Requests\Company\UpdateCompanyOrderRequest;
use App\Services\Interfaces\CompanyOrderServiceInterface;
use App\Http\Resources\Company\CreateCompanyOrderResource;
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

        return GetCompanyOrdersResource::collection($orders);
    }

    /**
     * @param ShowCompanyOrderRequest $request
     * @return ShowCompanyOrderResource
     */
    public function show(ShowCompanyOrderRequest $request): ShowCompanyOrderResource
    {
        $dto   = ShowCompanyOrderDTO::getFromRequest($request);
        $order = $this->companyOrderService->show($dto);

        return new ShowCompanyOrderResource($order);
    }

    /**
     * @param CreateCompanyOrderRequest $request
     * @return CreateCompanyOrderResource
     */
    public function create(CreateCompanyOrderRequest $request): CreateCompanyOrderResource
    {
        $dto   = CreateCompanyOrderDTO::getFromRequest($request);
        $order = $this->companyOrderService->create($dto);

        return new CreateCompanyOrderResource($order);
    }

    /**
     * @param UpdateCompanyOrderRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCompanyOrderRequest $request): JsonResponse
    {
        $dto = UpdateCompanyOrderDTO::getFromRequest($request);
        $this->companyOrderService->update($dto);

        return response()->json(
            [
                'message' => "your request was successful",
            ], Response::HTTP_OK);
    }

}
