<?php

namespace App\Http\Resources\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'type_id' => $this->type->name,
            'parent_id' => $this->parent_id == 0 ? "PARTENT" : Category::find($this->parent_id)->name,
            'created_at' => $this->created_at
        ];
    }
}
