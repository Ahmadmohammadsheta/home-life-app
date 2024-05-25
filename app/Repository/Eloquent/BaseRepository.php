<?php

namespace App\Repository\Eloquent;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Traits\ImageProccessingTrait;
use App\Repository\EloquentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements EloquentRepositoryInterface
{
    use ImageProccessingTrait;

    /**
     * @var Model
     */
    protected $model;

    /**
     * Resource Class
     * @var Resource
     */
    protected $resourceCollection;



    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function paginate($total = null): LengthAwarePaginator
    {
        return $this->model->paginate($total);
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param id $attributes
     * @return Model
     */
    public function edit($id, array $attributes)
    {
        $data = $this->model->findOrFail($id);
        $data->update($attributes);
        return $data;
    }

    /**
     * Soft delete a model row
     */
    public function softDelete($id): ?Model
    {
        $data = $this->model->findOrFail($id);

        $data->delete();

        return $data;
    }

    /**
     * @param $id
     * @return response
     * Force delete a model row
     */
    public function forceDelete($id): ?Model
    {
        $data = $this->model->onlyTrashed()->findOrFail($id);

        $data->forceDelete();

        return $data;
    }

    /**
     * Write code on Method
     *
     * @return response
     */
    public function forceDeleteAll()
    {
        return $this->model->onlyTrashed()->forceDelete();
    }

    /**
     * Return the trashed data as a collection
     *
     * @return Builder
     */
    public function trashed(): Builder
    {
        return $this->model->onlyTrashed();
    }

    /**
     * Write code on Method
     * @param $id
     * @return Model
     */
    public function restore($id): Model
    {
        $data = $this->model->onlyTrashed()->findOrFail($id);

        $data->restore();

        return $data;
    }

    public function restoreAll()
    {
        return $this->model->onlyTrashed()->restore();
    }
}
