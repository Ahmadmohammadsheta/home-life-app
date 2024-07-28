<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Repository\TypeRepositoryInterface;

class TypeController extends Controller
{
    /**
     * Repository constructor method
     */
    public function __construct(private TypeRepositoryInterface $repository) {
        $this->repository = $repository;
        $this->additionalData = $this->additionalData(new Type, 'type');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $types = Type::with('categories')
        // ->select('categories.*')
        // ->addSelect(DB::raw('(SELECT COUNT(*) FROM categories WHERE parent_id = categories.id ) as categories_count'))
        // ->selectRaw('(SELECT COUNT(*) FROM categories WHERE id = categories.parent_id ) as categories_count')
        // ->withCount(// relation as new_name)
            // ->withCount([
            //     'relation_name as new_name' => function($query){
            //         $query->where('is_parent', true); // to add new condition to the withCount
            //     }
            // ])
            // ->paginate(29);
        $data = $this->repository->paginate();

        return request()->wantsJson() ?
        response()->json($data) :
        view('crud.index', ['data' => $data], ['columns' => $this->repository->columns()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.create', ['type' => new Type(),  'columnsWithDataTypes'=>$this->repository->columnsTypes()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->repository->create($request->all());
            return redirect()->route($this->additionalData['tableName'].'.index')->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']);
        } catch (\Throwable $th) {
            return  redirect()->back()->with(['session' => 'danger', 'message' => 'An error occured']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        // eagerLoading throw the object chain the relation method not the relation property then the builder return or paginate return
        $categories = $type // object
            ->categories() // relation method
            ->with(['children', 'things'])
            ->latest()
            ->get() // builder return
            ->paginate(5); // paginate return
        return view('crud.show', [$this->additionalData['modelObjectName'] => $type, 'columns' => $this->repository->columns()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('crud.edit', [$this->additionalData['modelObjectName'] => $type, 'columnsWithDataTypes'=> $this->repository->columnsTypes()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $this->repository->edit($type->id, $request->all());

        return redirect()->route($this->additionalData['tableName'].'.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Type $type)
    {
        $this->repository->softDelete($type->id);
        return redirect()->route($this->additionalData['tableName'].'.index')->with('success', 'تم الحذف بنجاح');
    }
}
