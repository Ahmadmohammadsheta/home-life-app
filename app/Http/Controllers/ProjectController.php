<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\SqlDataRetrievable;
use Illuminate\Support\Facades\Schema;
use App\Repository\ProjectRepositoryInterface;
use App\Http\Resources\Project\ProjectResource;

class ProjectController extends Controller
{
    use SqlDataRetrievable;
    /**
     * Properties
     */
    public $projectRepository;
    public $tableName;
    public $modelObjectName;
    public $columnsAsKeys;
    public $columnsAsValues;


    /**
     * Repository constructor method
     */
    public function __construct(ProjectRepositoryInterface $projectRepository) {
        $this->projectRepository = $projectRepository;
        $this->tableName = $this->modelTableName(new Project());
        $this->modelObjectName = 'project';
        $this->columnsAsKeys = $this->columnKeysNamesEqualColumnNames(new Project, ['updated_at']);
        $this->columnsAsKeys['user_id'] = 'USER NAME'; $this->columnsAsKeys['type_id'] = 'TYPE NAME'; $this->columnsAsKeys['created_at'] = 'CREATED AT';
        $this->columnsAsValues = $this->filteredTableColumnNames(new Project, ['updated_at']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filterColumnNames = $this->filteredTableColumnNames(new Project, ['updated_at']);
        $columns = $this->columnKeysNamesEqualColumnNames(new Project, ['updated_at']);
        $columns['type_id'] = 'TYPE NAME'; $columns['user_id'] = 'USER NAME'; $columns['created_at'] = 'CREATED AT';

        $data = json_encode(ProjectResource::collection($this->projectRepository->all()));

        return view('CRUD.index', ['data' => $data, 'columns' => $columns, 'filterColumnNames' => $filterColumnNames,  'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columsWithDataTypes = $this->getColumnType(new Project(), ['id', 'created_at', 'updated_at']);
        return view('CRUD.create', ['columsWithDataTypes'=>$columsWithDataTypes, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->projectRepository->create($request->all());

        return redirect()->route($this->tableName.'.index')->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $filterColumnNames = $this->filteredTableColumnNames(new Project(), ['updated_at']);
        return view('CRUD.show', [$this->modelObjectName => json_decode((new ProjectResource($project))->toJson(), true), 'filterColumnNames' => $filterColumnNames, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $columsWithDataTypes = $this->getColumnType(new Project(), ['id', 'created_at', 'updated_at']);
        return view('CRUD.edit', [$this->modelObjectName => $project, 'columsWithDataTypes'=>$columsWithDataTypes, 'modelObjectName' => $this->modelObjectName, 'tableName' => $this->tableName]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->projectRepository->edit($project->id, $request->all());

        return redirect()->route($this->tableName.'.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Project $project)
    {
        $this->projectRepository->delete($project->id);
        return redirect()->route($this->tableName.'.index')->with('success', 'تم الحذف بنجاح');
    }
}
