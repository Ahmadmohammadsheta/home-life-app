<?php
namespace App\Repository;

interface CategoryRepositoryInterface {

    /**
     * @param id $parentId
     *
     * @return array
     */
    public function thisMembers($parentId): array;
}
