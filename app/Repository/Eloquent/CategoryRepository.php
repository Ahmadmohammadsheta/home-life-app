<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Repository\CategoryRepositoryInterface;
use App\Http\Traits\SqlDataRetrievable;

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
    *
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

        if (array_key_exists('image', $attributes)) {
            $this->deleteImage($data['image']); // Working only if file exists
        }

        if (isset($attributes['parent_id'])) {
            $parent = $this->find($attributes['parent_id']);
            $attributes['all_parents_ids'] = implode(',', [$parent->all_parents_ids, $parent->id]);
        }

        isset($attributes['is_parent']) ?: $attributes['is_parent'] = false;

        $data->update($attributes);

        return $data;
    }

   /**
    * Delete a model row
    */
    public function delete($id): ?Model
    {
        $data = $this->model->findOrFail($id);

        $this->deleteImage('categories', $data['image']); // Working only if file exists

        $data->delete();
        return $data;
    }
}
