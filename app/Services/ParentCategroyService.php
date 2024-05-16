<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class ParentCategroyService
{
    /**
     * AMA custom
     * Properties
     */
    // private $child;

    /**
     * Repository constructor method
     */
    public function __construct(private ChildCategroyService $child) {
        $this->child = $child;
    }

    /**
     * @return Collection
     * get only the parents categories
     */
    public function parentCategories(): Collection
    {
        $category =Category::where(['parent_id' => 0])->first();
        // if ($category->types()->exists()) {
        //     throw new \Exception("$category already has an invoice");
        // }
        return Category::where(['parent_id' => 0])->get();
    }

    /**
     * @param $id
     * get only the child of shown category
     */
    public function parents_ids($id)
    {
        $parent = Category::where(['id' => $id])->with('parent')->get();

        return $parent;
    }

   /**
    * @param array $attributes
    *
    * @return Collection
    */
    public function categoriesWhereNotMeWhereNotChild($id): Collection
    {
        $idArray = $this->child->getAllChildrenIds($id);
        array_push($idArray, $id);

        $data = Category::whereNotIn('id', $idArray)
            ->where(function ($query) {
                $query->where('is_parent', true); // Nested OR condition
            })
            ->get();

        return ($data);
    }
}
