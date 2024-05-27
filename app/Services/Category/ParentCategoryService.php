<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

class ParentCategoryService
{
    /**
     * Repository constructor method
     */
    public function __construct(private ChildCategoryService $child, private Category $category) {}

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
        $thisParents = [];

        $parentsIds = explode(',', $category->all_parents_ids);

        $parents = $this->category->whereIn('id', $parentsIds)->paginate();

        foreach ($parents as $thisParent) {
            $thisParents[] = $thisParent;
            $parentsIds = explode(',', $thisParent->all_parents_ids);
            $parents = $this->category->whereIn('id', $parentsIds)->paginate();
        }

        return ($thisParents);
    }

   /**
    * @param Category $category
    * @return array
    * Recursive the data
    */
    public function allParentsForThisSonAsTree(Category $category): array
    {
        $tree = [
            'id' => $category->id,
            'parent' => [],
        ];

        $parentsIds = explode(',', $category->all_parents_ids);

        $thisParents = $this->category->whereIn('id', $parentsIds)->get();

        if ($category->all_parents_ids > 0) {
            foreach ($thisParents as $parent) {

                $tree['parent'][] = $this->allParentsForThisSon($parent);

            }
        }

        return ($tree);
    }




    function iterateTree(Category $category)
    {
        $tree = $this->allParentsForThisSon($category);
        $new = [];
        // dd($tree);
        foreach ($tree['parent'] as $branch) {
            $new[] = $branch['parent'];
            if (isset($branch['1'])) {
            }
        };
        // foreach ($tree as $branch) {
        //     // Access node attributes (assuming 'name' and 'children')

        //     if (isset($branch['parent'])) {
        //         $new[] = $branch['parent'];
        //         $this->iterateTree($branch['parent'], $level + 1);
        //     }
        // }

        return dd($new);
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
