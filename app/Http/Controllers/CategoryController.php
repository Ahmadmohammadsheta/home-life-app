<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Traits\SqlDataRetrievable;
use Illuminate\Support\Facades\Schema;
use App\Repository\CategoryRepositoryInterface;
use App\Http\Resources\Category\CategoryResource;

class CategoryController extends Controller
{
    use SqlDataRetrievable;
    /**
     * Properties
     */
    public $categoryRepository;
    public $tableName;
    public $modelObjectName;


    /**
     * Repository constructor method
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
        $this->tableName = $this->modelTableName(new Category());
        $this->modelObjectName = 'category';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterColumnNames = $this->filteredTableColumnNames(new Category, ['image', 'updated_at']);
        $columns = $this->columnKeysNamesEqualColumnNames(new Category, ['image', 'updated_at']);
        $columns['parent_id'] = 'PARENT NAME'; $columns['type_id'] = 'TYPE NAME'; $columns['created_at'] = 'CREATED AT';

        $data = json_encode(CategoryResource::collection($this->categoryRepository->all()));

        return view('CRUD.index', ['data' => $data,  'columns' => $columns, 'filterColumnNames' => $filterColumnNames, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columsWithDataTypes = $this->getColumnType(new Category(), ['id', 'created_at', 'updated_at']);
        return view('CRUD.create', ['columsWithDataTypes'=>$columsWithDataTypes, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->file('image'));
        $this->categoryRepository->create($request->all());
        return redirect()->route($this->tableName.'.index')->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $filterColumnNames = $this->filteredTableColumnNames(new Category(), ['updated_at']);
        return view('CRUD.show', [$this->modelObjectName => json_decode((new CategoryResource($category))->toJson(), true), 'filterColumnNames' => $filterColumnNames, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $columsWithDataTypes = $this->getColumnType(new Category(), ['id', 'created_at', 'updated_at']);
        return view('CRUD.edit', [$this->modelObjectName => $category, 'columsWithDataTypes'=>$columsWithDataTypes, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $this->categoryRepository->edit($category->id, $request->all());

        return $request->wantsJson() ?
        $this->sendResponse($data, "تم التعديل بنجاح", 200) :
        redirect()->route($this->tableName.'.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        $this->categoryRepository->delete($category->id);
        return $request->wantsJson() ?
        $this->sendResponse("تم الحذف بنجاح", 200) :
        redirect()->route($this->tableName.'.index')->with('success', 'تم الحذف بنجاح');
    }
}
