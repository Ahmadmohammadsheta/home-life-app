<?php

namespace App\Http\Resources\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function getAllParents($parentId): array
    {
        $currentId = $parentId;
        // gst in array
        $parents = Category::where('id', $currentId)->first();
        if ($parents) {
            $parents->parents = $this->getAllParents($parents->parent_id);
        }

        // get  recuiters
        $parents = [];
        while ($currentId) {
            $parent = Category::where('id', $currentId)->first();
            if ($parent) {
                $parents[] = $parent->name;
                $currentId = $parent->parent_id;
            } else {
                $currentId = null; // No parent found, break the loop
            }
        }
        return $parents;
    }

// Access data in the tree structure

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
            'is_parent' => $this->is_parent ==0 ? 'True' : 'False',
            'parent_id' => $this->parent_id == 0 ? "PARTENT" : Category::find($this->parent_id)->name,
            'category_id' => $this->parent_id != 0 ? $this->parent_id : $this->id,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'parents' => $this->getAllParents($this->id),
            'all_parents_ids' => '',
            // 'parent' => $this->when($request->has('parent'), optional($this->parent)->toArray()),
            // 'children' => $this->when($request->has('children'), optional($this->children)->toArray()),
        ];
    }


    public function with(Request $request): array
    {
        return [
            'parent' => $this->whenLoaded('parent'),  // Eager load parent if requested in 'with'
            'children' => $this->whenLoaded('children'),  // Eager load children if requested in 'with'
        ];
    }
}
