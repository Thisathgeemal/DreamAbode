<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chat_id'                => $this->chat_id,
            'sender'                 => new UserResource($this->whenLoaded('sender')),
            'receiver'               => new UserResource($this->whenLoaded('receiver')),
            'message'                => $this->message,
            'is_read'                => $this->is_read,
            'deleted_by_sender_at'   => $this->deleted_by_sender_at,
            'deleted_by_receiver_at' => $this->deleted_by_receiver_at,
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
        ];
    }
}
