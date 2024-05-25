<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Services\Category\CategroyService;
use App\Repository\CategoryRepositoryInterface;
use App\Services\Category\ChildCategroyService;
use App\Services\Category\ThingCategroyService;
use App\Services\Category\ParentCategroyService;
use App\Http\Resources\Category\CategoryResource;

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
        $request = request();

        $data = CategoryResource::collection($this->service->indexWithParentName($request->all(), 7));
        // dd($data);
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
            ->with(['session' => 'success', 'message' => "The $data->name has been updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->repository->softDelete($category->id);

        return request()->wantsJson() ?
        response()->json("تم الحذف بنجاح", 200) :
        redirect()->route($this->uriRoute.'.index')->with(['session' => 'success', 'message' => "The $category->name has been deleted successfully"]);
    }

    /**
     * Get the trashed data.
     */
    public function trashed()
    {
        $request = request();

        $data = CategoryResource::collection($this->service->trashed($request->all(), 7));

        return request()->wantsJson() ? response()->json($data) :
        view('crud.trashed',
        ['data' => $data],
        ['columns' => $this->service->columns()]);
    }

    /**
     * Get the trashed data.
     */
    public function restore(Request $request,$id)
    {
        $data = $this->repository->restore($id);

        return request()->wantsJson() ? response()->json($data) :
        redirect()->route($this->uriRoute.'.index',
        [
            'data' => $data,
            'columns' => $this->service->columns()
        ])
        ->with(['session' => 'success', 'message' => "The $data->name has been restored successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $data = $this->repository->forceDelete($id);

        return request()->wantsJson() ?
        response()->json("تم الحذف بنجاح", 200) :
        redirect()->route($this->uriRoute.'.trashed')->with(['session' => 'success', 'message' =>  "The $data->name has been deleted successfully"]);
    }
}
