<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

class ParentCategroyService
{
    /**
     * Repository constructor method
     */
    public function __construct(private ChildCategroyService $child, private Category $category) {}

    /**
     * @return Collection
     * get only the parents categories
     */
    public function allParents(): Collection
    {
        $category = $this->category->where(['parent_id' => 0])->first();
        // if ($category->type()->exists()) {
        //     throw new \Exception("$category already has an invoice");
        // }
        return $this->category->where(['parent_id' => 0])->get();
    }

   /**
    * @param Category $category
    * @return array
    */
    public function allParentsForThisSon(Category $category): array
    {
        $tree = [
            'id' => $category->id,
            'parents' => [],
        ];

        // if ($category->all_parents_ids > 0) {
        //     $parentsIds = explode(',', $category->all_parents_ids);
        //     $thisParents = $this->category->whereIn('id', $parentsIds)->get();
        //     foreach ($thisParents as $parent) {
        //         $tree['parents'][] = $this->allParentsForThisSon($parent);
        //     }
        // }

        // $tree = [
        //     'id' => $category->id,
        //     'parents' => [],
        // ];
        // if ($category->all_parents_ids > 0) {
        //     $parentsIds = explode(',', $category->all_parents_ids);
        //     $thisParents = $this->category->whereIn('id', $parentsIds)->get();
        //     foreach ($thisParents as $parent) {
        //         $tree['parents'][] = $this->allParentsForThisSon($parent);
        //         dd($tree, 1);
        //     }
        // }
        // dd($tree, 2);



        // $currentId = $category->id;
        // // gst in array
        // $parent = $this->category->where('id', $currentId)->first();
        // if ($parent) {
        //     $parent->parent = $this->allParentsForThisSon($category);
        // }

        // // get  recuiters
        // $parents = [];
        // while ($currentId) {
        //     $parent = $this->category->where('id', $currentId)->first();
        //     if ($parent) {
        //         $parents[] = $parent->name;
        //         $currentId = $parent->parent_id;
        //     } else {
        //         $currentId = null; // No parent found, break the loop
        //     }
        // }
        return ($tree);
    }

   /**
    * @param id $id
    *
    * @return Collection
    */
    public function parentsWhereNotThis($id): Collection
    {
        $idArray = $this->child->idsOfAllChildrenWhereThisParent($id);
        array_push($idArray, $id);

        $data = $this->category->whereNotIn('id', $idArray)
            ->where(function ($query) {
                $query->where('is_parent', true); // Nested OR condition
            })
            ->get();

        return ($data);
    }
}
