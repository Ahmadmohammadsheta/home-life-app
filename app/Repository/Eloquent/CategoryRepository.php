<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
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
     * @return Collection
     * get only the parents categories
     */
    public function parentCategories(): Collection
    {
        return $this->model->where(['parent_id' => 0])->get();
    }

    /**
     * @return Collection
     * get only the child of shown category
     */
    public function childCategories($parent_id): Collection
    {
        return $this->model->where(['parent_id' => $parent_id])->get();
    }

    /**
     * @param $id
     * get only the child of shown category
     */
    public function parents_ids($id)
    {
        $parent = Category::where(['id' => $id])->with('parent')->get();

        return $parent;
    }

   /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        !array_key_exists('image', $attributes) ?: $attributes['image'] = $this->setImage($attributes['image'], 'categories');

        $attributes['all_parents_ids'] = implode(',', [$this->find($attributes['id'])->all_parents_ids ?: 1, $this->find($attributes['id'])->id]);

        isset($attributes['is_parent']) ?: $attributes['is_parent'] = 1;

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
            $this->deleteImage('categories', $data['image']); // Working only if file exists
            $attributes['image'] = $this->setImage($attributes['image'], 'categories');
        }

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
