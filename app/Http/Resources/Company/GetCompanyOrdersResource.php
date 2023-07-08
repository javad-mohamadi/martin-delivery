<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetCompanyOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'company_id'         => $this->company_id,
            'provider_name'      => $this->provider_name,
            'provider_mobile'    => $this->provider_mobile,
            'provider_address'   => $this->provider_address,
            'provider_latitude'  => $this->provider_latitude,
            'provider_longitude' => $this->provider_longitude,
            'receiver_name'      => $this->receiver_name,
            'receiver_mobile'    => $this->receiver_mobile,
            'receiver_address'   => $this->receiver_address,
            'receiver_latitude'  => $this->receiver_latitude,
            'receiver_longitude' => $this->receiver_longitude,
            'status'             => $this->status,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
        ];
    }
}
