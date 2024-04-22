<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Traits\SqlDataRetrievable;
use App\Repository\CategoryRepositoryInterface;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\NonParentResource;

class CategoryController extends Controller
{
    use SqlDataRetrievable;

    /**
     * Properties
     */
    public $categoryRepository;
    public $tableName;
    public $modelObjectName;
    public $columnsAsKeys;
    public $columnsAsValues;


    /**
     * Repository constructor method
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
        $this->tableName = $this->modelTableName(new Category);
        $this->modelObjectName = 'category';
        $this->columnsAsKeys = $this->columnKeysNamesEqualColumnNames(new Category, ['updated_at']);
        $this->columnsAsKeys['parent_id'] = 'PARENT NAME'; $this->columnsAsKeys['category_id'] = 'CATEGORY NAME'; $this->columnsAsKeys['type_id'] = 'TYPE NAME'; $this->columnsAsKeys['created_at'] = 'CREATED AT';
        $this->columnsAsValues = $this->filteredTableColumnNames(new Category, ['updated_at']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = $this->columnsAsKeysAndValues(new Category(), ['updated_at', 'all_parents_ids'], ['parent_id' => 'PARENT NAME', 'category_id' => 'CATEGORY NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);

        $data = CategoryResource::collection($this->categoryRepository->parentCategories());

        return view('CRUD.index', ['data' => $data], ['columns' => $columns]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columsWithDataTypes = $this->getColumnType(new Category(), ['id', 'created_at', 'updated_at', 'all_parents_ids']);
        return view('CRUD.create', ['columsWithDataTypes' => $columsWithDataTypes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $this->categoryRepository->create($request->all());

        if ($data->parent_id == 0) {
            return redirect()->route(request()->route()->controller->tableName.'.index')->with('success', 'تم الاضافة بنجاح');
        }
        return redirect()->route(request()->route()->controller->tableName.'.show', ['category' => $data->parent_id])->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $columns = $this->columnsAsKeysAndValues(new Category(), ['updated_at'], ['all_parents_ids' => 'PARENTS', 'parent_id' => 'PARENT NAME', 'category_id' => 'CATEGORY NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);

        $finalCategoryData = $this->categoryRepository->finalCategory($category->id);

        $data = $this->categoryRepository->getAllChildren($category->id);

        $return = [$this->modelObjectName => (new CategoryResource($category)),
            'data' => CategoryResource::collection($data),
            'finalCategoryData' => NonParentResource::collection($finalCategoryData),
            'thisFinalCategoryData' => NonParentResource::collection($category->things),
            'childrenData' => CategoryResource::collection($category->children)
        ];

        return request()->wantsJson() ?
        response()->json($return, 200) :
        view('CRUD.show', $return, ['columns' => $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $columsWithDataTypes = $this->getColumnType(new Category(), ['id', 'created_at', 'updated_at']);
        return view('CRUD.edit', [$this->modelObjectName => $category, 'columsWithDataTypes'=>$columsWithDataTypes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $this->categoryRepository->edit($category->id, $request->all());

        return $request->wantsJson() ?
        $this->sendResponse($data, "تم التعديل بنجاح", 200) :
        redirect()->route(request()->route()->controller->tableName.'.show', [$this->modelObjectName => $data->parent_id])->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        $this->categoryRepository->delete($category->id);
        return $request->wantsJson() ?
        $this->sendResponse("تم الحذف بنجاح", 200) :
        redirect()->route(request()->route()->controller->tableName.'.index')->with('success', 'تم الحذف بنجاح');
    }
}
