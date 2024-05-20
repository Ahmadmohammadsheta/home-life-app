<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Repository\ProjectRepositoryInterface;
use App\Http\Resources\Project\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Repository constructor method
     */
    public function __construct(private ProjectRepositoryInterface $repository) {
        $this->additionalData = $this->additionalData(new Project, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = $this->repository->columns();
        $data = ProjectResource::collection($this->repository->all());

        return view('crud.index', ['data' => $data, 'columns' => $columns]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columsWithDataTypes = $this->repository->columnsTypes();
        $arrayForSelectInput = $this->repository->arrayForSelectInput();

        return view('crud.create', [
            'project' => new Project(),
            'columsWithDataTypes'=>$columsWithDataTypes,
            'arrayForSelectInput' => $arrayForSelectInput
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());
        return redirect()->route($this->additionalData['tableName'].'.index')->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']);
        try {
        } catch (\Throwable $th) {
            return  redirect()->back()->with(['session' => 'danger', 'message' => 'An error occured']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $columns = $this->repository->columns();

        return view('crud.show', [$this->additionalData['modelObjectName'] => new ProjectResource($project), 'columns' => $columns]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $columsWithDataTypes = $this->repository->columnsTypes();

        return view('crud.edit', [$this->additionalData['modelObjectName'] => $project, 'columsWithDataTypes'=>$columsWithDataTypes, 'modelObjectName' => $this->additionalData['modelObjectName'], 'tableName' => $this->additionalData['tableName']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->repository->edit($project->id, $request->all());
        return redirect()->route($this->additionalData['tableName'].'.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Project $project)
    {
        $this->repository->delete($project->id);
        return redirect()->route($this->additionalData['tableName'].'.index')->with('success', 'تم الحذف بنجاح');
    }
}
