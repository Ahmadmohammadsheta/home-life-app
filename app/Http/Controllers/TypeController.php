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
    public function __construct(TypeRepositoryInterface $repository) {
        $this->repository = $repository;
        $this->additionalData = $this->additionalData(new Type, 'type');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('crud.index', ['data' => $this->repository->all(), 'columns' => $this->repository->columns()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud.create', ['type' => new Type(),  'columsWithDataTypes'=>$this->repository->columnsTypes()]);
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
        return view('crud.show', [$this->additionalData['modelObjectName'] => $type, 'columns' => $this->repository->columns()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('crud.edit', [$this->additionalData['modelObjectName'] => $type, 'columsWithDataTypes'=> $this->repository->columnsTypes()]);
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
        $this->repository->delete($type->id);
        return redirect()->route($this->additionalData['tableName'].'.index')->with('success', 'تم الحذف بنجاح');
    }
}
