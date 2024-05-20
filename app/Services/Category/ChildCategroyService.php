<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;

class ChildCategroyService
{
    /**
     * Child Services constructor method
     */
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private Category $category) {}

    /**
    * @param id $parentId
     * @return array
     * get all the children Category of shown category ass an array
     */
    public function allChildrenWhereThisParent($parentId): array
    {
        $thisChildren = [];

        $members = $this->repository->thisMembers($parentId);
        foreach ($members as $member) {
            $member->is_parent == 'True' ? array_push($thisChildren, $member) : '';
        }

        return ($thisChildren);
    }

    /**
    * @param id $parentId
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
