<?php

namespace App\Http\Controllers;

use App\Models\Thing;
use Illuminate\Http\Request;
use App\Http\Traits\SqlDataRetrievable;
use App\Http\Resources\Thing\ThingResource;
use App\Repository\ThingRepositoryInterface;

class ThingController extends Controller
{
    use SqlDataRetrievable;

    /**
     * Properties
     */
    public $thingRepository;
    public $tableName;
    public $modelObjectName;


    /**
     * Repository constructor method
     */
    public function __construct(ThingRepositoryInterface $thingRepository) {
        $this->thingRepository = $thingRepository;
        $this->tableName = $this->modelTableName(new Thing());
        $this->modelObjectName = 'thing';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = $this->columnsAsKeysAndValues(new Thing, ['updated_at'], ['member_id' => 'Member NAME', 'category_id' => 'CATEGORY NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);
        $data = json_encode(ThingResource::collection($this->thingRepository->all()));

        return view('crud.index', ['data' => $data], ['columns' => $columns]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columsWithDataTypes = $this->getColumnType(new Thing(), ['id', 'created_at', 'updated_at']);
        return view('crud.create', ['columsWithDataTypes'=>$columsWithDataTypes, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->thingRepository->create($request->all());

        return redirect()->route($this->tableName.'.index')->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Thing $thing)
    {
        $columns = $this->columnsAsKeysAndValues(new Thing, ['updated_at'], ['member_id' => 'Member NAME', 'category_id' => 'CATEGORY NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);
        return view('crud.show', [$this->modelObjectName => json_decode((new ThingResource($thing))->toJson(), true)], ['columns' => $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thing $thing)
    {
        $columsWithDataTypes = $this->getColumnType(new Thing(), ['id', 'created_at', 'updated_at']);
        return view('crud.edit', [$this->modelObjectName => $thing, 'columsWithDataTypes'=>$columsWithDataTypes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thing $thing)
    {
        $data = $this->thingRepository->edit($thing->id, $request->all());

        return $request->wantsJson() ?
        $this->sendResponse($data, "تم التعديل بنجاح", 200) :
        redirect()->route(request()->route()->controller->tableName.'.show', [$this->modelObjectName => $thing->id])->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thing $thing)
    {
        $this->thingRepository->delete($thing->id);
        return redirect()->route($this->tableName.'.index')->with('success', 'تم الحذف بنجاح');
    }
}
