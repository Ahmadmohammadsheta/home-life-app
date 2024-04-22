<?php

namespace App\Http\Resources\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NonParentResource extends JsonResource
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
                $parents[] = $parent;
                $currentId = $parent->parent_id;
            } else {
                $currentId = null; // No parent found, break the loop
            }
        }
        return $parents;
    }


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
            // 'parent' => $this->getAllParents($this->id),
            'created_at' => $this->created_at,
            'all_parents_ids' => $this->all_parents_ids,
        ];
    }
}
