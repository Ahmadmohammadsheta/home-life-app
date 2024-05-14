<?php

namespace App\Repository\Eloquent;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ImageProccessingTrait;
use App\Repository\EloquentRepositoryInterface;

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
     * Delete a model row
     */
    public function delete($id): ?Model
    {
        $data = $this->model->findOrFail($id);

        $data->delete();
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

    public function forceDelete($id): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($id)->forceDelete();
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
     * Write code on Method
     * @param $id
     * @return Model
     */
    public function restore($id)
    {
        return $this->model->withTrashed()->findOrFail($id)->restore();
    }

    /**
     * Write code on Method
     *
     * @return Model
     */
    // public function getDelete()
    // {
    //     return $this->model->withTrashed()->get();

    // }

    public function restoreAll()
    {
        return $this->model->onlyTrashed()->restore();
    }
}
