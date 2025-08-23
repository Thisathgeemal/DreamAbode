<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyAdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'property_id'   => $this->property_id,
            'property_name' => $this->property_name,
            'property_type' => $this->property_type,
            'location'      => $this->location,
            'measurement'   => $this->measurement,
            'perches'       => $this->perches,
            'bedrooms'      => $this->bedrooms,
            'bathrooms'     => $this->bathrooms,
            'floors'        => $this->floors,
            'price'         => $this->price,
            'post_type'     => $this->post_type,
            'status'        => $this->status,

            'agent'         => new UserResource($this->whenLoaded('agent')),
            'admin'         => new UserResource($this->whenLoaded('admin')),
            'member'        => new UserResource($this->whenLoaded('member')),

            'images'        => ImageResource::collection($this->whenLoaded('images')),

            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
