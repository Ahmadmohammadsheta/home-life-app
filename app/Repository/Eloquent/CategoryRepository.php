<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
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
    public function childCategories($parentId): Collection
    {
        return $this->model
            ->where(['parent_id' => $parentId])
            ->with(['parent', 'children'])
            ->get();
    }

    /**
     * @return array
     * get all the children Category of shown category ass an array
     */
    public function getAllChildren($parentId): array
    {
        $currentId = $parentId;

        $children = [];
        $currentChildren = $this->model->where('parent_id', $currentId)->get();

        foreach ($currentChildren as $child) {
            if ($child->is_parent == true) {
                $children[] = $child;
                $children = array_merge($children, $this->getAllChildren($child->id));
            }
        }

        return $children;
    }

    /**
     * @return array
     * get all the children Category of shown category as a tree
     */
    public function getAllChildrenTree(Category $category): array
    {
        $tree = [
            'id' => $category->id,
            'parentsIds' => $category->all_parents_ids,
            'children' => [],
        ];

        foreach ($category->children as $child) {
            if (Route::currentRouteName() === 'categories.update') {
                $array = [];
                $array['all_parents_ids'] = implode(',', [$this->find($child['parent_id'])->all_parents_ids, $this->find($child['parent_id'])->id]);
                $child->update($array);
            }
            $tree['children'][] = $this->getAllChildrenTree($child);
        }

        return $tree;
    }

    /**
     * @return array
     * get all the things Category of shown category as a tree
     */
    public function getAllThingsTree(Category $category): array
    {
        $tree = [
            'id' => $category->id,
            'parentsIds' => $category->all_parents_ids,
            'things' => [],
        ];

        foreach ($category->things as $thing) {
            if (Route::currentRouteName() === 'categories.update') {
                $array = [];
                $array['all_parents_ids'] = implode(',', [$this->find($thing['parent_id'])->all_parents_ids, $this->find($thing['parent_id'])->id]);
                $thing->update($array);
            }
            $tree['children'][] = $this->getAllChildrenTree($thing);
        }

        return $tree;
    }

    /**
     * @return array
     * get only the final Category of shown category (things)
     */
    public function thingsCategories($parentId): array
    {
        $all = $this->model
            ->where('is_parent', false)
            ->get();

        $thingsCategories = [];
        foreach ($all as $single) {
            $all_parents_ids = explode(',', $single->all_parents_ids);
            if (in_array($parentId, $all_parents_ids)) {
                array_push($thingsCategories, $single);
                // $thingsCategories[] = $single;
            }
        }
        return $thingsCategories;
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

        // if the new category is a child
        if (isset($attributes['id'])) {

            $all_parents_ids = $this->find($attributes['id'])->all_parents_ids;

            $attributes['all_parents_ids'] = $all_parents_ids != null ? implode(',', [$all_parents_ids, $attributes['id']]) : $attributes['id'];
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
            $this->deleteImage('categories', $data['image']); // Working only if file exists
            $attributes['image'] = $this->setImage($attributes['image'], 'categories');
        }

        if ($attributes['parent_id'] > 0) {
            $attributes['all_parents_ids'] = implode(',', [$this->find($attributes['parent_id'])->all_parents_ids, $this->find($attributes['parent_id'])->id]);
        }

        isset($attributes['is_parent']) ? $attributes['is_parent'] = true : $attributes['is_parent'] = false;

        $data->update($attributes);

        $this->getAllChildrenTree($data);
        $this->getAllThingsTree($data);

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

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function columns(): array
    {
        if (route('categories.index')) {
            $columns = $this->columnsAsKeysAndValues(new Category(), ['updated_at', 'all_parents_ids'], ['parent_id' => 'PARENT NAME', 'category_id' => 'CATEGORY NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);
        } else {
            $columns = $this->columnsAsKeysAndValues(new Category(), ['updated_at'], ['all_parents_ids' => 'PARENTS', 'parent_id' => 'PARENT NAME', 'category_id' => 'CATEGORY NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);
        }

        return $columns;
    }

   /**
    * getColumnType
    * @return array
    */
    public function columnsTypes(): array
    {
        return $this->getColumnType(new Category(), ['id', 'created_at', 'updated_at', 'all_parents_ids']);
    }
}
