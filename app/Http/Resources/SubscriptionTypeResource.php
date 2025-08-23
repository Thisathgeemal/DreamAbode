<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type_id'          => $this->type_id,
            'type_name'        => $this->type_name,
            'duration_days'    => $this->duration_days,
            'base_amount'      => $this->base_amount,
            'discount_percent' => $this->discount_percent,
            'final_price'      => $this->final_price,

            'subscriptions'    => SubscriptionResource::collection($this->whenLoaded('subscriptions')),

            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
    }
}
