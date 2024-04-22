<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Repository\TypeRepositoryInterface;
use App\Http\Traits\SqlDataRetrievable as SqlDataRetrievable;

class TypeController extends Controller
{
    use SqlDataRetrievable;
    /**
     * Properties
     */
    public $typeRepository;
    public $tableName;
    public $modelObjectName;


    /**
     * Repository constructor method
     */
    public function __construct(TypeRepositoryInterface $typeRepository) {
        $this->typeRepository = $typeRepository;
        $this->tableName = $this->modelTableName(new Type());
        $this->modelObjectName = 'type';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = $this->columnsAsKeysAndValues(new Type(), ['updated_at'], ['craeted_at' => 'CRAETED At']);

        $data = $this->typeRepository->all();

        return view('CRUD.index', ['data' => $data, 'columns' => $columns]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columsWithDataTypes = $this->getColumnType(new Type(), ['id', 'created_at', 'updated_at']);
        return view('CRUD.create', ['columsWithDataTypes'=>$columsWithDataTypes, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->typeRepository->create($request->all());
        return redirect()->route($this->tableName.'.index')->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        $columns = $this->columnsAsKeysAndValues(new Type(), ['updated_at'], ['user_id' => 'USER NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);
        return view('CRUD.show', [$this->modelObjectName => $type, 'columns' => $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        $columsWithDataTypes = $this->getColumnType(new Type(), ['id', 'created_at', 'updated_at']);
        return view('CRUD.edit', [$this->modelObjectName => $type, 'columsWithDataTypes'=>$columsWithDataTypes, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $this->typeRepository->edit($type->id, $request->all());

        return redirect()->route($this->tableName.'.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Type $type)
    {
        $this->typeRepository->delete($type->id);
        return redirect()->route($this->tableName.'.index')->with('success', 'تم الحذف بنجاح');
    }
}
