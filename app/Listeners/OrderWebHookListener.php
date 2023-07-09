<?php

namespace App\Listeners;

use App\Events\OrderWebHookEvent;
use App\Services\WebHookService;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderWebHookListener implements ShouldQueue
{
    /**
     *
     */
    public function __construct(private WebHookService $webHookService)
    {
    }

    /**
     * @param OrderWebHookEvent $event
     * @return void
     */
    public function handle(OrderWebHookEvent $event): void
    {
        $this->webHookService->notify($event->webHookUrl, $event->orderId);
    }
}
