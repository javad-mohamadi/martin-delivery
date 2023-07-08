<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderWebHookEvent
{
    use Dispatchable,
        InteractsWithSockets,
        SerializesModels,
        Queueable;

    /**
     * @param string $webHookUrl
     * @param int $orderId
     */
    public function __construct(public string $webHookUrl, public int $orderId)
    {
    }

}
