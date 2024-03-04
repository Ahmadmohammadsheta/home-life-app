<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Traits\GetSqlDataTrait as GetSqlDataTrait;
use Illuminate\Support\Facades\Schema;
use App\Repository\TypeRepositoryInterface;

class TypeController extends Controller
{
    use GetSqlDataTrait;
    /**
     * Properties
     */
    public $typeRepository;


    /**
     * Repository constructor method
     */
    public function __construct(TypeRepositoryInterface $typeRepository) {
        $this->typeRepository = $typeRepository;
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
        $this->sendResponse($data, "", 200) : view('types.index', ['data' => $data, 'columns' => $columns, 'filter_column_names' => $filter_column_names]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('types.create');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        //
    }
}
