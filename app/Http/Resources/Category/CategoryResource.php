<?php

namespace App\Http\Resources\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function parents(): array
    {
        $all_parents_ids = (explode(',', Category::find($this->id)->all_parents_ids));
        $parents = [];
        if (!is_null($all_parents_ids)) {
            foreach ($all_parents_ids as $singleId) {
                $category = Category::find($singleId);
                dd($category->name);
                array_push($parents, $category);
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
            'all_parents_ids' => $this->allParents(),
            'parent_id' => $this->parent_id == 0 ? "PARTENT" : Category::find($this->parent_id)->name,
            'category_id' => $this->parent_id != 0 ? $this->parent_id : $this->id,
            'type' => $this->type,
            'parent' => new CategoryResource($this->parent),
            'created_at' => $this->created_at,
            'children' => $this->when($request->has('children'), optional($this->children)->toArray()),
            // 'all_parents_ids' => json_encode($this->parents())
        ];
    }


    public function with(Request $request): array
    {
        return [
            'parent' => $this->whenLoaded('parent'),  // Eager load posts if requested in 'with'
        ];
    }
}
