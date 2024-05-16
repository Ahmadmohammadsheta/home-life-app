<?php

namespace App\Services;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Route;

class ThingCategroyService
{
    /**
     * AMA custom
     * Properties
     */
    // private $repository;
    // private $child;

    /**
     * Repository constructor method
     */
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private ChildCategroyService $child
        ) {}

    /**
     * @return array
     * get all the things Category of shown category as a tree
     */
    public function getAllThingsCategoriesTree(Category $category): array
    {
        $tree = [
            'id' => $category->id,
            'parentsIds' => $category->all_parents_ids,
            'things' => [],
        ];

        foreach ($category->things as $thing) {
            if (Route::currentRouteName() === 'categories.update') {
                $array = [];
                $array['all_parents_ids'] = implode(',', [$this->repository->find($thing['parent_id'])->all_parents_ids, $this->repository->find($thing['parent_id'])->id]);
                $thing->update($array);
            }
            $tree['children'][] = $this->child->getAllChildrenTree($thing);
        }

        return $tree;
    }

    /**
     * @return array
     * get only the final Category of shown category (things)
     */
    public function getAllThingsCategories($parentId): array
    {
        $all = Category::where('is_parent', false)
            ->get();

        $getAllThingsCategories = [];
        foreach ($all as $single) {
            $all_parents_ids = explode(',', $single->all_parents_ids);
            if (in_array($parentId, $all_parents_ids)) {
                array_push($getAllThingsCategories, $single);
            }
        }
        return $getAllThingsCategories;
    }
}
