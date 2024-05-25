<?php

namespace App\Services\Category;

use App\Models\Type;
use App\Models\Category;
use App\Repository\Eloquent\TypeRepository;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Traits\SqlDataRetrievable; // AMA custom trait

class CategroyService
{
    use SqlDataRetrievable; // AMA custom use

    /**
     * Repository constructor method
     */
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private ParentCategroyService $parentService,
        private ChildCategroyService $childService,
        private ThingCategroyService $thingService,
        private Category $category
        ) {}


    /**
     * @return LengthAwarePaginator
     */
    public function filterPaginate(array $attributes, $total): LengthAwarePaginator
    {
        return $this->category->filter($attributes)->isParentDesc()->paginate($total);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function indexWithParentName(array $attributes, $total): LengthAwarePaginator
    {
        return $this->category->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id' )
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            ->filter($attributes)
            ->isParentDesc()
            ->paginate($total);
    }
    /**
     * Return the trashed data as a collection
     *
     * @return LengthAwarePaginator
     */
    public function trashed(array $attributes): LengthAwarePaginator
    {
        return $this->repository->trashed()->filter($attributes)->paginate(5);
    }

   /**
    * columnsAsKeysAndValues
    * @param Category $category
    * @return array
    */
    public function returnToShowData(Category $category): array
    {
        $data = [
            'category' => new CategoryResource($category->with(['type', 'parent'])->find($category->id)),
            'allRelatedChildren' => CategoryResource::collection($this->childService->allChildrenWhereThisParent($category->id)), // get all the children data in the {$data}
            'thisRelatedChildren' => CategoryResource::collection($category->children()->paginate()), // get this children data only
            'allRelatedThings' => CategoryResource::collection($this->thingService->allThingsWhereThisParent($category->id)), // get all children data has no parent (all things)
            'thisRelatedThings' => CategoryResource::collection($category->things()->paginate()), // get this children data has no parent (this things)
            'allParentsForThisSon' => $this->parentService->allParentsForThisSon($category) // get this children data has no parent (this things)
        ];
        return ($data);
    }

   /**
    * columnsAsKeysAndValues
    * @param Category $category
    * @return array
    */
    public function returnToFormData(Category $category = null): array
    {
        $data = [
            'category' => $category ?: $category = new Category(),
            'columsWithDataTypes' => $this->columnsTypes(),
            'arrayForSelectInput' => $this->arrayForSelectInput(isset($category) ? $category->id : null),
            'allChildren' => isset($category) ? $this->childService->idsOfAllChildrenWhereThisParent($category->id) : []
        ];

        return $data;
    }

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function columns(): array
    {
        $data = [
            'custom' => ['id', 'name', 'image', 'parent_name', 'is_parent', 'typeName'],
            'columnsAsKeys' => ['id', 'name', 'Image', 'Parent', 'Is parent', 'Type'],
            'excepted' => ['all_parents_ids'],
        ];
        if (route('categories.index')) {
            $columns = $this->columnsAsKeysAndValues(new Category(), $data);
        } else {
            $columns = $this->columnsAsKeysAndValues(new Category(), $data);
        }

        return ($columns);
    }

   /**
    * getColumnType
    * @return array
    */
    public function columnsTypes(): array
    {
        $data = [
            'excepted' => ['id', 'created_at', 'updated_at', 'all_parents_ids']
        ];
        return $this->getColumnType(new Category(), $data);
    }

   /**
    * getColumnType
    * @param id $categoryId
    * @return array
    */
    public function arrayForSelectInput($categoryId = null): array
    {

        $types = (new TypeRepository(new Type))->all();

        $categories = isset($categoryId) ? $this->parentService->parentsWhereNotThis($categoryId) : $this->category->all();
        $arrayForSelectInput = [
            [
                'data' => $categories,
                'to' =>'parent_id'
            ],
            [
                'data' => $types,
                'to' =>'type_id'
            ],
        ];
        return $arrayForSelectInput;
        // $error = throw new InvalidArgumentException();
    }



















    public function pushStatus(Category $category, int $status) {
        $category->update(['status' => $status]);
        // Potentially other operations?
    }
    public function createInvoice(Category $category) {
        if ($category->invoice()->exists()) {
            throw new \Exception('catego$category already has an invoice');
        }

        return DB::transaction(function() use ($category) {
            $invoice = $category->invoice()->create();
            $this->pushStatus($category, 2);
            return $invoice;
        });
    }
    // public function store(array $userData): Category
    // {
        // $question = $this->category->find($userData['id']);
        // abort_if(
        //     $question->user_id == auth()->id(),
        //     500,
        //     'You are not allowed to vote on your own question'
        // );
        // if ($question->user_id == auth()->id()) {
        //     throw new \Exception('You are not allowed to vote on your own question');
        // } try {
        //     $voice = $service->store($request->input('question_id'), $request->input('value'));
        // } catch (\Exception $e) {
        //     abort(500, $e->getMessage());
        // }
        // return new Category();
    // }
}
