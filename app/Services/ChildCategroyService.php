<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use App\Repository\CategoryRepositoryInterface;

class ChildCategroyService
{
    /**
     * AMA custom
     * Properties
     */
    // private $repository;

    /**
     * Repository constructor method
     */
    public function __construct(private CategoryRepositoryInterface $repository) {}

    /**
     * @return Collection
     * get only the child of shown category
     */
    public function childCategories($parentId): Collection
    {
        return Category::where(['parent_id' => $parentId])
            ->with(['parent', 'children'])
            ->get();
    }

    /**
     * @return array
     * get all the children Category of shown category ass an array
     */
    public function getAllChildren($parentId): array
    {
        $currentId = $parentId;

        $children = [];
        $currentChildren = Category::where('parent_id', $currentId)->get();

        foreach ($currentChildren as $child) {
            if ($child->is_parent == true) {
                $children[] = $child;
                $children = array_merge($children, $this->getAllChildren($child->id));
            }
        }

        return $children;
    }

    /**
     * @return array
     * get all the children Category of shown category ass an array
     */
    public function getAllChildrenIds($parentId): array
    {
        $currentId = $parentId;

        $childrenIds = [];

        $children = $this->getAllChildren($currentId);

        foreach ($children as $child) {
            $childrenIds[] = $child->id;
        }

        return $childrenIds;
    }

    /**
     * @return array
     * get all the children Category of shown category as a tree
     */
    public function getAllChildrenTree(Category $category): array
    {
        $tree = [
            'id' => $category->id,
            'parentsIds' => $category->all_parents_ids,
            'children' => [],
        ];

        foreach ($category->children as $child) {
            if (Route::currentRouteName() === 'categories.update') {
                $array = [];
                $array['all_parents_ids'] = implode(',', [$this->repository->find($child['parent_id'])->all_parents_ids, $this->repository->find($child['parent_id'])->id]);
                $child->update($array);
            }
            $tree['children'][] = $this->getAllChildrenTree($child);
        }

        return $tree;
    }
}
