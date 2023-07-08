<?php

namespace App\Http\Resources\Courier;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCourierOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'order_id'     => $this->order_id,
            'status'       => $this->status,
            'accepted_at'  => $this->accepted_at,
            'received_at'  => $this->received_at,
            'delivered_at' => $this->delivered_at,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'order'        => $this->order
        ];
    }
}
