<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class ChildCategoryService
{
    /**
     * Child Services constructor method
     */
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private Category $category) {}

    /**
    * @param id $parentId
     * @return Collection
     * get all the children Category of shown category ass an array
     */
    public function allChildrenWhereThisParent($parentId): Collection
    {
        $thisChildren = [];

        $members = $this->repository->thisMembers($parentId);
        foreach ($members as $member) {
            $member->is_parent == true ? array_push($thisChildren, $member) : '';
        }

        return Collection::make($thisChildren);
    }

    /**
    * @param id $parentId
     * @return array
     * get all the children Category of shown category ass an array
     */
    public function idsOfAllChildrenWhereThisParent($parentId): array
    {
        $childrenIds = [];

        $children = $this->allChildrenWhereThisParent($parentId);

        foreach ($children as $child) {
            $childrenIds[] = $child->id;
        }

        return $childrenIds;
    }

    /**
     * @param Category $category
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

            $tree['children'][] = $this->allChildrenWhereThisParentAsTree($child);

        }

        return $tree;
    }
}
