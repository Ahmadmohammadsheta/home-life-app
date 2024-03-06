<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\GetSqlDataTrait;
use Illuminate\Support\Facades\Schema;
use App\Repository\ProjectRepositoryInterface;
use App\Http\Resources\Project\ProjectResource;

class ProjectController extends Controller
{
    use GetSqlDataTrait;
    /**
     * Properties
     */
    public $ProjectRepository;
    public $tableName;


    /**
     * Repository constructor method
     */
    public function __construct(ProjectRepositoryInterface $ProjectRepository) {
        $this->ProjectRepository = $ProjectRepository;
        $this->tableName = $this->modelTableName(new Project());
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter_column_names = $this->filteredTableColumnNames(new Project, ['updated_at']);
        $columns = $this->columnKeysNamesEqualColumnNames(new Project, ['updated_at']);
        $columns['type_id'] = 'TYPE NAME';
        $columns['user_id'] = 'USER NAME';
        $columns['created_at'] = 'CREATED AT';

        $data = json_encode(ProjectResource::collection($this->ProjectRepository->all()));

        return $request->wantsJson() ?
        $this->sendResponse($data, "", 200) :
        view('CRUD.index', ['data' => $data, 'columns' => $columns, 'filter_column_names' => $filter_column_names, 'tableName' => $this->tableName]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columnNames = $this->filteredTableColumnNames(new Project(), ['id', 'created_at', 'updated_at']);

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
        $data = $this->ProjectRepository->create($request->all());

        return $request->wantsJson() ?
        $this->sendResponse($data, 'تم الاضافة بنجاح.', 201) :
        redirect()->route($this->tableName.'.index')->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $columnNames = $this->filteredTableColumnNames(new Project(), ['id', 'created_at', 'updated_at']);

        foreach ($columnNames as $columnName) {
            $colum_data_types[] = (["name" => $columnName, "type" => Schema::getColumnType($this->tableName, $columnName)]);
        }
        return view('CRUD.edit', ['project' => $project, 'columns'=>$colum_data_types, 'tableName' => $this->tableName]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $this->ProjectRepository->edit($project->id, $request->all());

        return $request->wantsJson() ?
        $this->sendResponse($data, "تم التعديل بنجاح", 200) :
        redirect()->route($this->tableName.'.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Project $project)
    {
        $this->ProjectRepository->delete($project->id);
        return $request->wantsJson() ?
        $this->sendResponse("تم الحذف بنجاح", 200) :
        redirect()->route($this->tableName.'.index')->with('success', 'تم الحذف بنجاح');
    }
}
