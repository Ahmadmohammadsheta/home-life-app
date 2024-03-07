<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface CategoryRepositoryInterface
{

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

   /**
    * @param array $attributes
    * @return Collection
    */
    public function categroiesForAllConditions(array $attributes);

    /**
     * Get categories of a project.
     *
     * @return Collection
     */
    public function categoriesOfProject($project_id);
}
