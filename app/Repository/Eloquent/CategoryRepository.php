<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
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
            $attributes['all_parents_ids'] = $parent->all_parents_ids != null ? implode(',', [$parent->all_parents_ids, $attributes['parent_id']]) : $attributes['parent_id'];
        }

        isset($attributes['is_parent']) ?: $attributes['is_parent'] = false;

        $data->update($attributes);

        if ($thisMembers != null) {
            foreach ($thisMembers as $thisMember) {
                $all_parents_ids = implode(',', [$data->all_parents_ids, $id]);
                $thisMember->update(['all_parents_ids' => $all_parents_ids]);
            }
        }

        return $data;
    }

   /**
    * Delete a model row
     * @return Model
    */
    public function delete($id): ?Model
    {
        $data = $this->model->findOrFail($id);

        $this->deleteImage('categories', $data['image']); // Working only if file exists

        $data->delete();
        return $data;
    }

    /**
     * @param id $parentId
     *
     * @return array
     */
    public function thisMembers($parentId): array
    {
        $thisMembers = [];

        $allChildrenAndThings = $this->model->with(['parent', 'type'])->get();
        foreach ($allChildrenAndThings as $childOrThing) {
            $allParentsIds = explode(',', $childOrThing->all_parents_ids);
            if (in_array($parentId, $allParentsIds)) {
                array_push($thisMembers, $childOrThing);
            }
        }
        return $thisMembers;
    }
}
