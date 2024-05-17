<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class ParentCategroyService
{
    /**
     * Repository constructor method
     */
    public function __construct(private ChildCategroyService $child) {}

    /**
     * @return Collection
     * get only the parents categories
     */
    public function allParents(): Collection
    {
        $category =Category::where(['parent_id' => 0])->first();
        // if ($category->type()->exists()) {
        //     throw new \Exception("$category already has an invoice");
        // }
        return Category::where(['parent_id' => 0])->get();
    }

    public function allParentsForThisSon($parentId): array
    {
        $currentId = $parentId;
        // gst in array
        $parents = Category::where('id', $currentId)->first();
        if ($parents) {
            $parents->parents = $this->allParentsForThisSon($parents->parent_id);
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

   /**
    * @param array $attributes
    *
    * @return Collection
    */
    public function parentsWhereNotThis($id): Collection
    {
        $idArray = $this->child->idsOfAllChildrenWhereThisParent($id);
        array_push($idArray, $id);

        $data = Category::whereNotIn('id', $idArray)
            ->where(function ($query) {
                $query->where('is_parent', true); // Nested OR condition
            })
            ->get();

        return ($data);
    }
}
