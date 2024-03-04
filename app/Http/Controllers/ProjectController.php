<?php

namespace App\Http\Controllers;

use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Repository\ProjectRepositoryInterface;
use App\Http\Traits\GetSqlDataTrait;

class ProjectController extends Controller
{
    use GetSqlDataTrait;
    /**
     * Properties
     */
    public $ProjectRepository;


    /**
     * Repository constructor method
     */
    public function __construct(ProjectRepositoryInterface $ProjectRepository) {
        $this->ProjectRepository = $ProjectRepository;
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

        // dd($filter_column_names, $data);
        return $request->wantsJson() ?
        $this->sendResponse($data, "", 200) : view('projects.index', ['data' => $data, 'columns' => $columns, 'filter_column_names' => $filter_column_names]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
