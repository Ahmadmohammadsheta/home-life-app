<?php
namespace App\Repository;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface EloquentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @return LengthAwarePaginator
     */
    public function paginate($total = null): LengthAwarePaginator ;

   /**
    * @param array $attributes
    * @return Model
    */
   public function create(array $attributes): Model;

   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;

   /**
    * @param id $attributes
    * @return Model
    */
    public function edit($id, array $attributes);

    /**
    * @param $id
    * @return response
    */
    public function softDelete($id): ?Model;


    /**
    * @param $id
    * @return response
    */
    public function forceDelete($id): ?Model;

    /**
     * Return the trashed data as a collection
     *
     * @return Builder
     */
    public function trashed(): Builder;

    /**
     * Write code on Method
     *
     * @return Model
     */
    public function restore($id): Model;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function restoreAll();
}
