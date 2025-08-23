<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'subscription_id'   => $this->subscription_id,
            'member'            => new UserResource($this->whenLoaded('member')),
            'subscription_type' => new SubscriptionTypeResource($this->whenLoaded('subscriptionType')),
            'start_date'        => $this->start_date,
            'end_date'          => $this->end_date,
            'status'            => $this->status,
            'payment'           => new PaymentResource($this->whenLoaded('payment')),
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
