<?php
namespace App\Repository;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface {

    /**
     * @return Collection
     * get only the parents category
     */
    public function parentCategories(): Collection;


    /**
     * @return Collection
     * get only the child of shown category
     */
    public function childCategories($parent_id): Collection;
}
