<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\DTOs\Courier\GetCourierOrdersDTO;
use App\DTOs\Courier\ShowCourierOrderDTO;
use App\DTOs\Courier\UpdateCourierOrderDTO;
use App\DTOs\Courier\CreateCourierOrderDTO;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Courier\CourierOrdersResource;
use App\Http\Resources\Courier\PendingOrdersResource;
use App\Http\Requests\Courier\ShowCourierOrderRequest;
use App\Http\Requests\Courier\GetCourierOrdersRequest;
use App\Http\Requests\Courier\GetPendingOrdersRequest;
use App\Http\Requests\Courier\UpdateCourierOrderRequest;
use App\Http\Requests\Courier\AcceptCourierOrderRequest;
use App\Http\Resources\Courier\ShowCourierOrderResource;
use App\Services\Interfaces\CourierOrderServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CourierOrderController extends Controller
{
    /**
     * @param CourierOrderServiceInterface $courierOrderService
     */
    public function __construct(protected CourierOrderServiceInterface $courierOrderService)
    {
    }

    /**
     * @param GetPendingOrdersRequest $request
     * @return AnonymousResourceCollection
     */
    public function getPendingOrders(GetPendingOrdersRequest $request): AnonymousResourceCollection
    {
        $orders = $this->courierOrderService->getPendingOrders();

        return PendingOrdersResource::collection($orders);
    }

    /**
     * @param GetCourierOrdersRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetCourierOrdersRequest $request): AnonymousResourceCollection
    {
        $dto    = GetCourierOrdersDTO::getFromRequest($request);
        $orders = $this->courierOrderService->index($dto);

        return CourierOrdersResource::collection($orders);
    }

    /**
     * @param ShowCourierOrderRequest $request
     * @return ShowCourierOrderResource
     */
    public function show(ShowCourierOrderRequest $request): ShowCourierOrderResource
    {
        $dto = ShowCourierOrderDTO::getFromRequest($request);
        $order = $this->courierOrderService->show($dto);

        return new ShowCourierOrderResource($order);
    }

    /**
     * @param AcceptCourierOrderRequest $request
     * @return JsonResponse
     */
    public function acceptOrder(AcceptCourierOrderRequest $request): JsonResponse
    {
        $dto = CreateCourierOrderDTO::getFromRequest($request);
        $this->courierOrderService->acceptOrder($dto);

        return response()->json(
            [
                'message' => "Your request has been successfully registered",
            ], Response::HTTP_OK);
    }

    /**
     * @param UpdateCourierOrderRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCourierOrderRequest $request): JsonResponse
    {
        $dto = UpdateCourierOrderDTO::getFromRequest($request);
        $this->courierOrderService->update($dto);

        return response()->json(
            [
                'message' => "Your request has been successfully updated",
            ], Response::HTTP_OK);
    }
}
