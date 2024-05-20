<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use App\Repository\CategoryRepositoryInterface;

class ThingCategroyService
{
    /**
     * Repository constructor method
     */
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private ChildCategroyService $child,
        private Category $category
        ) {}

    /**
     * @return Collection
     * get all the things Category of shown category as a tree
     */
    public function allThings(): Collection
    {
        $allThings = $this->category->where('is_parent', false)->get();

        return $allThings;
    }

    /**
    * @param id $parentId
     * @return array
     * get only the final Category of shown category (things)
     */
    public function allThingsWhereThisParent($parentId): array
    {
        $thisThings = [];

        $members = $this->repository->thisMembers($parentId);

        foreach ($members as $member) {
            $member->is_parent == 'False' ? array_push($thisThings, $member) : '';
        }

        return ($thisThings);
    }

    /**
     * @param Category $category
     * @return array
     * get all the things Category of shown category as a tree
     */
    public function allThingsWhereThisParentAsTree(Category $category): array
    {
        $tree = [
            'id' => $category->id,
            'parentsIds' => $category->all_parents_ids,
            'things' => [],
        ];

        foreach ($category->things as $thing) {
            $tree['children'][] = $this->child->allChildrenWhereThisParentAsTree($thing);
        }

        return $tree;
    }
}
