<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectAdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'project_id'      => $this->project_id,
            'project_name'    => $this->project_name,
            'property_type'   => $this->property_type,
            'location'        => $this->location,
            'total_units'     => $this->total_units,
            'measurement'     => $this->measurement,
            'price'           => $this->price,
            'status'          => $this->status,
            'completion_date' => $this->completion_date,

            'agent'           => new UserResource($this->whenLoaded('agent')),
            'admin'           => new UserResource($this->whenLoaded('admin')),
            'member'          => new UserResource($this->whenLoaded('member')),

            'images'          => ImageResource::collection($this->whenLoaded('images')),

            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
