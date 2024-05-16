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
    public function __construct(private ChildCategroyService $child) {}

    /**
     * @return Collection
     * get only the parents categories
     */
    public function parentCategories(): Collection
    {
        $category =Category::where(['parent_id' => 0])->first();
        // if ($category->type()->exists()) {
        //     throw new \Exception("$category already has an invoice");
        // }
        return Category::where(['parent_id' => 0])->get();
    }

   /**
    * @param array $attributes
    *
    * @return Collection
    */
    public function categoriesWhereNotThisWhereNotChild($id): Collection
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
