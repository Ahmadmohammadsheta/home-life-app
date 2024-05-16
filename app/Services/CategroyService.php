<?php

namespace App\Services;

use App\Models\Type;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Repository\Eloquent\TypeRepository;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\NonParentResource;
use App\Http\Traits\SqlDataRetrievable; // AMA custom trait

class CategroyService
{
    use SqlDataRetrievable; // AMA custom use

    /**
     * AMA custom
     * Properties
     */
    // private $parent;
    // private $childService;
    // private $thingService;

    /**
     * Repository constructor method
     */
    public function __construct(
        private ParentCategroyService $parent,
        private ChildCategroyService $childService,
        private ThingCategroyService $thingService
        ) {
            $this->parent = $parent;
            $this->childService = $childService;
            $this->thingService = $thingService;
    }

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function returnToShowData(Category $category): array
    {
        $returnData = [
            'category' => new CategoryResource($category),
            'data' => CategoryResource::collection($this->childService->getAllChildren($category->id)), // get all the children data in the {$data}
            'childrenData' => CategoryResource::collection($category->children), // get this children data only
            'allRelatedThings' => NonParentResource::collection($this->thingService->thingsCategories($category->id)), // get all children data has no parent (all things)
            'thisRelatedThings' => NonParentResource::collection($category->things) // get this children data has no parent (this things)
        ];
        return $returnData;
    }

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function returnToFormData(Category $category = null): array
    {
        $returnData = [
            'category' => $category ?: $category = new Category(),
            'columsWithDataTypes' => $this->columnsTypes(),
            'arrayForSelectInput' => $this->arrayForSelectInput(isset($category) ? $category->id : null),
            'allChildren' => isset($category) ? $this->childService->getAllChildrenIds($category->id) : []
        ];

        return $returnData;
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

   /**
    * getColumnType
    * @return array
    */
    public function arrayForSelectInput($categoryId = null): array
    {

        $types = (new TypeRepository(new Type))->all();

        $categories = isset($categoryId) ? $this->parent->categoriesWhereNotMeWhereNotChild($categoryId) : Category::all();
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
        // $question = Category::find($userData['id']);
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
