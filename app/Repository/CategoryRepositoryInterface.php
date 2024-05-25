<?php
namespace App\Repository;

use Illuminate\Support\Collection;

interface CategoryRepositoryInterface {

    /**
     * @param id $parentId
     *
     * @return Collection
     */
    public function thisMembers($parentId): Collection;
}
