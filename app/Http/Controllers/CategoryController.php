<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Category\CategroyService;
use App\Services\Category\ChildCategroyService;
use App\Services\Category\ParentCategroyService;
use App\Services\Category\ThingCategroyService;

class CategoryController extends Controller
{
    /**
     * Repository constructor method
     */
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private CategroyService $service,
        private ParentCategroyService $parentService,
        private ChildCategroyService $childService,
        private ThingCategroyService $thingService,
        ) {
            $this->additionalData = $this->additionalData(new Category, 'category');
            $this->uriRoute = $this->additionalData['tableName'];
        }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CategoryResource::collection($this->repository->all());
        return request()->wantsJson() ? response()->json($data) :
        view('crud.index',
        ['data' => $data],
        ['columns' => $this->service->columns()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->service->returnToFormData();

        return response()->view('crud.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $this->repository->create($request->validated());

        return request()->wantsJson() ? response()->json($data) :
            (
                $data->parent_id == 0 ? redirect()->route($this->uriRoute.'.index')->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']) :
                redirect()->route($this->uriRoute.'.show', ['category' => $data->parent_id])->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح'])
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $data = $this->service->returnToShowData($category);

        return request()->wantsJson() ?
        response()->json($data) :
        view('crud.show', $data, ['columns' => $this->service->columns()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $data = $this->service->returnToFormData($category);

        return view('crud.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $this->repository->edit($category->id, $request->validated());

        return $request->wantsJson() ?
        $this->sendResponse($data, "تم التعديل بنجاح", 200) :
        redirect()->route($this->uriRoute.'.show',
            [
                $this->additionalData['modelObjectName'] => $data->parent_id ?: $data->id
            ])
            ->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->repository->delete($category->id);

        return request()->wantsJson() ?
        response()->json("تم الحذف بنجاح", 200) :
        redirect()->route($this->uriRoute.'.index')->with('success', 'تم الحذف بنجاح');
    }
}
