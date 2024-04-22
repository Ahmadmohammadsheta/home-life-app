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


    /**
     * Repository constructor method
     */
    public function __construct(ProjectRepositoryInterface $projectRepository) {
        $this->projectRepository = $projectRepository;
        $this->tableName = $this->modelTableName(new Project());
        $this->modelObjectName = 'project';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = $this->columnsAsKeysAndValues(new Project(), ['updated_at'], ['user_id' => 'USER NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);

        $data = ProjectResource::collection($this->projectRepository->all());

        return view('CRUD.index', ['data' => $data, 'columns' => $columns]);
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
        $columns = $this->columnsAsKeysAndValues(new Project(), ['updated_at'], ['user_id' => 'USER NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);
        return view('CRUD.show', [$this->modelObjectName => new ProjectResource($project), 'columns' => $columns]);
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
