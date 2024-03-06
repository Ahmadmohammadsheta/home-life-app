<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Repository\TypeRepositoryInterface;
use App\Http\Traits\GetSqlDataTrait as GetSqlDataTrait;

class TypeController extends Controller
{
    use GetSqlDataTrait;
    /**
     * Properties
     */
    public $typeRepository;
    public $tableName;


    /**
     * Repository constructor method
     */
    public function __construct(TypeRepositoryInterface $typeRepository) {
        $this->typeRepository = $typeRepository;
        $this->tableName = $this->modelTableName(new Type());
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter_column_names = $this->filteredTableColumnNames(new Type, ['updated_at']);
        $columns = $this->columnKeysNamesEqualColumnNames(new Type, ['updated_at']);
        $columns['created_at'] = 'CREATED AT';

        $data = $this->typeRepository->all();
        return $request->wantsJson() ?
        $this->sendResponse($data, "", 200) :
        view('CRUD.index', ['data' => $data, 'columns' => $columns, 'filter_column_names' => $filter_column_names, 'tableName' => $this->tableName]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columnNames = $this->filteredTableColumnNames(new Type(), ['id', 'created_at', 'updated_at']);

        foreach ($columnNames as $columnName) {
            $colum_data_types[] = (["name" => $columnName, "type" => Schema::getColumnType($this->tableName, $columnName)]);
        }
        return view('CRUD.create', ['columns'=>$colum_data_types, 'tableName' => $this->tableName]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->typeRepository->create($request->all());
        return $request->wantsJson() ?
        $this->sendResponse($data, 'تم الاضافة بنجاح.', 201) : redirect()->route('types.index')->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        $columnNames = $this->filteredTableColumnNames(new Type(), ['id', 'created_at', 'updated_at']);

        foreach ($columnNames as $columnName) {
            $colum_data_types[] = (["name" => $columnName, "type" => Schema::getColumnType($this->tableName, $columnName)]);
        }
        return view('CRUD.edit', ['type' => $type, 'columns'=>$colum_data_types, 'tableName' => $this->tableName]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $data = $this->typeRepository->edit($type->id, $request->all());

        return $request->wantsJson() ?
        $this->sendResponse($data, "تم التعديل بنجاح", 200) :
        redirect()->route($this->tableName.'.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Type $type)
    {
        $this->typeRepository->delete($type->id);
        return $request->wantsJson() ?
        $this->sendResponse("تم الحذف بنجاح", 200) :
        redirect()->route($this->tableName.'.index')->with('success', 'تم الحذف بنجاح');
    }
}
