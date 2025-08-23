<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'payment_id'   => $this->payment_id,
            'member'       => new UserResource($this->whenLoaded('member')),
            'amount'       => $this->amount,
            'description'  => $this->description,
            'subscription' => new SubscriptionResource($this->whenLoaded('subscription')),
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
