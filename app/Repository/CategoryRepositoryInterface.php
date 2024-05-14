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
    public function childCategories($parentId): Collection;

    /**
     * @return array
     * get only the child of shown category
     */
    public function getAllChildren($parentId): array;

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function columns(): array;

    /**
     * getColumnType
     * @return array
     */
     public function columnsTypes(): array;
}
