<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'name'                   => $this->name,
            'email'                  => $this->email,
            'mobile_number'          => $this->mobile_number,
            'address'                => $this->address,
            'gender'                 => $this->gender,
            'dob'                    => $this->dob,
            'user_roles'             => $this->user_roles,
            'is_active'              => $this->is_active,
            'profile_image'          => $this->profile_image,

            'subscriptions'          => SubscriptionResource::collection($this->whenLoaded('subscriptions')),
            'reviews'                => ReviewResource::collection($this->whenLoaded('reviews')),
            'property_ads'           => PropertyAdResource::collection($this->whenLoaded('propertyAds')),
            'property_agents'        => PropertyAdResource::collection($this->whenLoaded('propertyAgents')),
            'property_admin'         => PropertyAdResource::collection($this->whenLoaded('propertyAdmin')),
            'project_ads'            => ProjectAdResource::collection($this->whenLoaded('projectAds')),
            'project_agents'         => ProjectAdResource::collection($this->whenLoaded('projectAgents')),
            'project_admin'          => ProjectAdResource::collection($this->whenLoaded('projectAdmin')),
            'payments'               => PaymentResource::collection($this->whenLoaded('payments')),
            'notifications'          => NotificationResource::collection($this->whenLoaded('notifications')),
            'chat_messages_sent'     => ChatMessageResource::collection($this->whenLoaded('chatMessagesSent')),
            'chat_messages_received' => ChatMessageResource::collection($this->whenLoaded('chatMessagesReceived')),

            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
        ];
    }
}
