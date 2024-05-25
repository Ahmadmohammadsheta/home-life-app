<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\SqlDataRetrievable;
use Illuminate\Database\Eloquent\Model;
use App\Repository\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    use SqlDataRetrievable;

   /**
    * CategoryRepository constructor.
    *
    * @param Category $model
    */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }



   /**
    * @param array $attributes
    * @return Model
    */
    public function create(array $attributes): Model
    {
        // if the new category is a child
        if (isset($attributes['id'])) {

            $parent = $this->find($attributes['id']);

            $attributes['all_parents_ids'] = $parent->all_parents_ids != null ? implode(',', [$parent->all_parents_ids, $parent->id]) : $attributes['id'];
        }

        isset($attributes['is_parent']) ?: $attributes['is_parent'] = false;

        return $this->model->create($attributes);
    }

   /**
    * @param id $attributes
    * @return Model
    */
    public function edit($id, array $attributes)
    {
        $data = $this->model->findOrFail($id);
        $thisMembers = $this->thisMembers($id);

        if (array_key_exists('image', $attributes)) {
            $this->deleteImage($data['image']); // Working only if file exists
        }

        if (isset($attributes['parent_id'])) {
            $parent = $this->find($attributes['parent_id']);
            $attributes['all_parents_ids'] = $parent->all_parents_ids != null ? implode(',', [$parent->all_parents_ids, $parent->id]) : $attributes['parent_id'];
        }

        isset($attributes['is_parent']) ?: $attributes['is_parent'] = false;

        $data->update($attributes);

        if ($thisMembers != null) {
            foreach ($thisMembers as $thisMember) {
                $parent = $this->find($thisMember->parent_id);
                $all_parents_ids = implode(',', [$parent->all_parents_ids, $parent->id]);
                $thisMember->update(['all_parents_ids' => $all_parents_ids]);
            }
        }

        return $data;
    }

    /**
     * @return ?Model // thi mean if model find return the model else return null
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
        $data = $this->model->onlyTrashed()->findOrFail($id);

        try {
            // DB::beginTransaction();

            // Execute database operations here

            $this->deleteImage('categories', $data['image']); // Working only if file exists

            $data->forceDelete();

            return $data;

            // DB::commit();

        } catch (\Exception $e) {

            return $data;
            // DB::rollBack();

        }

    }

    /**
     * Write code on Method
     *
     * @return response
     */
    public function forceDeleteAll()
    {
        $data = $this->model->onlyTrashed();

        try {
            DB::beginTransaction();

            // Execute database operations here

            foreach ($data as $item) {
                $this->deleteImage('categories', $item['image']); // Working only if file exists
            }

            return $this->model->onlyTrashed()->forceDelete();

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();

        }
    }

    /**
     * @param id $parentId
     *
     * @return Collection
     */
    public function thisMembers($parentId): Collection
    {
        $thisMembers = [];

        $allChildrenAndThings = $this->model->with(['parent', 'type'])->get();
        foreach ($allChildrenAndThings as $childOrThing) {
            $allParentsIds = explode(',', $childOrThing->all_parents_ids);
            if (in_array($parentId, $allParentsIds)) {
                array_push($thisMembers, $childOrThing);
            }
        }

        return Collection::make($thisMembers);
    }
}
