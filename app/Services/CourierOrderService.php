<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Enum\OrderEnum;
use App\Enum\CourierOrderEnum;
use App\Events\OrderWebHookEvent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Exceptions\LogicException;
use App\Criteria\ThisUserCriteria;
use App\DTOs\Courier\ShowCourierOrderDTO;
use App\DTOs\Courier\GetCourierOrdersDTO;
use App\DTOs\Courier\UpdateCourierOrderDTO;
use App\DTOs\Courier\CreateCourierOrderDTO;
use Symfony\Component\HttpFoundation\Response;
use App\Criteria\Courier\ShowCourierOrderCriteria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Services\Interfaces\CompanyOrderServiceInterface;
use App\Services\Interfaces\CourierOrderServiceInterface;
use App\Services\Processor\Courier\UpdateStatusProcessor;
use App\Services\Processor\Courier\UpdateStatusToCanceled;
use App\Services\Processor\Courier\UpdateStatusToReceived;
use App\Services\Processor\Courier\UpdateStatusToDelivered;
use App\Repositories\CourierOrder\CourierOrderRepositoryInterface;

class CourierOrderService implements CourierOrderServiceInterface
{
    /**
     * @param CourierOrderRepositoryInterface $courierOrderRepository
     * @param CompanyOrderServiceInterface $companyOrderService
     * @param UpdateStatusToReceived $updateStatusToReceived
     * @param UpdateStatusToDelivered $updateStatusToDelivered
     * @param UpdateStatusToCanceled $updateStatusToCanceled
     */
    public function __construct(
        protected CourierOrderRepositoryInterface $courierOrderRepository,
        protected CompanyOrderServiceInterface    $companyOrderService,
        protected UpdateStatusToReceived          $updateStatusToReceived,
        protected UpdateStatusToDelivered         $updateStatusToDelivered,
        protected UpdateStatusToCanceled          $updateStatusToCanceled,
    )
    {
    }

    /**
     * @return mixed
     */
    public function getPendingOrders(): mixed
    {
        return $this->companyOrderService->getPendingOrders();
    }

    /**
     * @param GetCourierOrdersDTO $dto
     * @return LengthAwarePaginator|Collection|mixed
     * @throws LogicException
     */
    public function index(GetCourierOrdersDTO $dto): mixed
    {
        try {
            return $this->courierOrderRepository
                ->with('order')
                ->pushCriteria(new ThisUserCriteria($dto->courierId))
                ->paginate();
        } catch (Exception) {
            throw new LogicException(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param ShowCourierOrderDTO $dto
     * @return LengthAwarePaginator|Collection|mixed
     * @throws LogicException
     */
    public function show(ShowCourierOrderDTO $dto): mixed
    {
        try {
            return $this->courierOrderRepository
                ->with('order')
                ->pushCriteria(new ShowCourierOrderCriteria($dto->courierOrderId))
                ->pushCriteria(new ThisUserCriteria($dto->courierId))
                ->first();
        } catch (Exception) {
            throw new LogicException(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param CreateCourierOrderDTO $dto
     * @return void
     * @throws LogicException
     */
    public function acceptOrder(CreateCourierOrderDTO $dto)
    {
        try {
            DB::beginTransaction();
            $order = $this->companyOrderService->find($dto->orderId);
            if ($order->status != OrderEnum::STATUS_WAITING) {
                throw new LogicException(Response::HTTP_NOT_FOUND);
            }

            $order->lockForUpdate();
            $this->companyOrderService->updateOrderStatus($dto->orderId, OrderEnum::STATUS_EN_ROUTE);

            $data = [
                'user_id'     => $dto->courierId,
                'order_id'    => $dto->orderId,
                'status'      => CourierOrderEnum::STATUS_ACCEPTED,
                'accepted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];
            $this->courierOrderRepository->create($data);

            DB::commit();

            $webHookUrl = $order->company->webhook_url;
            event(new OrderWebHookEvent($webHookUrl, $dto->orderId));
        } catch (Exception) {
            DB::rollBack();
            throw new LogicException(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @throws LogicException
     */
    public function update(UpdateCourierOrderDTO $dto)
    {
        try {
            DB::beginTransaction();
            $courierOrder        = $this->courierOrderRepository->find($dto->courierOrderId);
            $updateStatusChecker = $this->getUpdateStatusChecker($dto->status);
            $courierOrderData    = $updateStatusChecker->process($courierOrder, $dto->status);
            $this->courierOrderRepository->update($courierOrderData, $dto->courierOrderId);

            $orderStatus = $this->defineOrderStatus($dto->status);
            $order = $this->companyOrderService->updateOrderStatus($courierOrder->order_id, $orderStatus);

            DB::commit();

            $webHookUrl = $order->company->webhook_url;
            event(new OrderWebHookEvent($webHookUrl, $courierOrder->order_id));
        } catch (Exception $e) {
            DB::rollBack();
            throw new LogicException(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param string $status
     * @return UpdateStatusProcessor
     */
    private function getUpdateStatusChecker(string $status): UpdateStatusprocessor
    {
        return match ($status) {
            CourierOrderEnum::STATUS_RECEIVED           => $this->updateStatusToReceived,
            CourierOrderEnum::STATUS_DELIVERED          => $this->updateStatusToDelivered,
            CourierOrderEnum::STATUS_EMERGENCY_CANCELED => $this->updateStatusToCanceled,
        };

    }

    /**
     * @param $courierStatus
     * @return string
     */
    private function defineOrderStatus($courierStatus): string
    {
        return match ($courierStatus) {
            CourierOrderEnum::STATUS_RECEIVED           => OrderEnum::STATUS_IN_TRANSIT,
            CourierOrderEnum::STATUS_DELIVERED          => OrderEnum::STATUS_DONE,
            CourierOrderEnum::STATUS_EMERGENCY_CANCELED => OrderEnum::STATUS_WAITING,
        };
    }
}
