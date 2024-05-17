<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Repository\CategoryRepositoryInterface;

class ChildCategroyService
{
    /**
     * Repository constructor method
     */
    public function __construct(private CategoryRepositoryInterface $repository) {}

    /**
     * @return array
     * get all the children Category of shown category ass an array
     */
    public function allChildrenWhereThisParent($parentId): array
    {
        $currentId = $parentId;

        $children = [];
        $currentChildren = Category::where('parent_id', $currentId)->get();

        foreach ($currentChildren as $child) {
            if ($child->is_parent == true) {
                $children[] = $child;
                $children = array_merge($children, $this->allChildrenWhereThisParent($child->id));
            }
        }

        return $children;
    }

    /**
     * @return array
     * get all the children Category of shown category ass an array
     */
    public function idsOfAllChildrenWhereThisParent($parentId): array
    {
        $currentId = $parentId;

        $childrenIds = [];

        $children = $this->allChildrenWhereThisParent($currentId);

        foreach ($children as $child) {
            $childrenIds[] = $child->id;
        }

        return $childrenIds;
    }

    /**
     * @return array
     * get all the children Category of shown category as a tree
     */
    public function allChildrenWhereThisParentAsTree(Category $category): array
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
            $tree['children'][] = $this->allChildrenWhereThisParentAsTree($child);
        }

        return $tree;
    }
}
