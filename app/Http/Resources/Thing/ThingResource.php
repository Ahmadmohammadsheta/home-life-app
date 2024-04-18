<?php

namespace App\Http\Resources\Thing;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image == null ? null : $this->image,
            'type_id' => $this->type->name,
            'category_id' => $this->category->name,
            'member_id' => $this->member->name,
            'created_at' => (new Carbon($this->created_at))->format('Y-m-d')
        ];
    }
}
