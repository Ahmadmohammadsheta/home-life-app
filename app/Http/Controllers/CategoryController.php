<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Repository\CategoryRepositoryInterface;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\NonParentResource;

class CategoryController extends Controller
{
    /**
     * Repository constructor method
     */
    public function __construct(CategoryRepositoryInterface $repository) {
        $this->repository = $repository;
        $this->additionalData = $this->additionalData(new Category, 'category');
        $this->uriRoute = $this->additionalData['tableName'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('crud.index', ['data' => CategoryResource::collection($this->repository->parentCategories())], ['columns' => $this->repository->columns()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('crud.create', [
            'category' => new Category(),
            'columsWithDataTypes' => $this->repository->columnsTypes(),
            'allChildren' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            $data = $this->repository->create($request->validated());

            if ($data->parent_id == 0) {
                return redirect()->route($this->uriRoute.'.index')->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']);
            }

            return redirect()->route($this->uriRoute.'.show', ['category' => $data->parent_id])->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']);

        } catch (\Throwable $th) {
            return  redirect()->back()->with(['session' => 'danger', 'message' => 'An error occured']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $return = [$this->additionalData['modelObjectName'] => new CategoryResource($category),
            'data' => CategoryResource::collection($this->repository->getAllChildren($category->id)), // get all the children data in the {$data}
            'childrenData' => CategoryResource::collection($category->children), // get this children data only
            'allRelatedThings' => NonParentResource::collection($this->repository->thingsCategories($category->id)), // get all children data has no parent (all things)
            'thisRelatedThings' => NonParentResource::collection($category->things) // get this children data has no parent (this things)
        ];

        return request()->wantsJson() ?
        response()->json($return) :
        view('crud.show', $return, ['columns' => $this->repository->columns()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('crud.edit', [
            $this->additionalData['modelObjectName'] => $category,
            'columsWithDataTypes' => $this->repository->columnsTypes(),
            'allChildren' => $this->repository->getAllChildrenIds($category->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $this->repository->edit($category->id, $request->validated());

        return $request->wantsJson() ?
        $this->sendResponse($data, "تم التعديل بنجاح", 200) :
        redirect()->route(request()->route()->controller->additionalData['tableName'].'.show', [$this->additionalData['modelObjectName'] => $data->parent_id ?: $data->id])->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        $this->repository->delete($category->id);
        return $request->wantsJson() ?
        $this->sendResponse("تم الحذف بنجاح", 200) :
        redirect()->route(request()->route()->controller->additionalData['tableName'].'.index')->with('success', 'تم الحذف بنجاح');
    }
}
