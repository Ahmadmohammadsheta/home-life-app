<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
// Access data in the tree structure

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['is_parent'] = $this->is_parent == 1 ? 'True' : 'False';
        $data['parent'] = new CategoryResource($this->parent);
        $data['type'] = $this->type;
        $data['typeName'] = $this->typeName;
        $data['relations'] = $this->with($request);


        return $data;
    }


    public function with(Request $request): array
    {
        return [
            'type' => $this->whenLoaded('type'),  // Eager load parent if requested in 'with'
            'parent' => $this->whenLoaded('parent'),  // Eager load parent if requested in 'with'
            'children' => $this->whenLoaded('children'),  // Eager load children if requested in 'with'
        ];
    }
}
