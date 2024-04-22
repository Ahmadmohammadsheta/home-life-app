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

    public function getAllChildren($parentId): array
    {
        $currentId = $parentId;

        $children = [];
        $currentChildren = Category::where('parent_id', $currentId)->get();

        foreach ($currentChildren as $child) {
            if ($child->is_parent === 0) {
                $children[] = $child;
                $children = array_merge($children, $this->getAllChildren($child->id));
            }
        }

        return $children;
    }

    public function getAllChildrenNames($parentId): array
    {
        // if (!empty($this->getAllChildren($parentId))) {
            foreach ($this->getAllChildren($parentId) as $child) {
                $children[] = $child->name; // Access child attributes
            }
        // } else {
            $children = ["None"];
        // }
        return $children;
    }

    public function getRecruiterTree(Category $category)
    {
        $tree = [
            'id' => $category->id,
            'name' => $category->name,
            'children' => [],
        ];

        foreach ($category->children as $child) {
            $tree['children'][] = $this->getRecruiterTree($child);
        }

        return $tree;
    }

    public function get2() {

        $currentId = $this->parent_id;

        $children = [];
        $currentChildren = Category::where('parent_id', $currentId)->get();

        foreach ($currentChildren as $child) {
            if ($child->is_parent === 0) {
                $children[] = $child;
                $children = array_merge($children, $this->children());
            }
        }

        $recruiter = Category::find($this->id); // Assuming ID 1 exists

        // Get all direct children of recruiter with ID 1
        $children = $recruiter->children;

        // Loop through children and access their data
        foreach ($children as $child) {
            $children[] =  $child->name;
        }

        return $children;
    }


// Access data in the tree structure

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->getAllChildren($this->id));
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
            // 'children' => $this->getAllChildren($this->id),
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
