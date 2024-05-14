<?php

namespace App\Repository\Eloquent;

use App\Models\Project;
use App\Repository\ProjectRepositoryInterface;
use App\Http\Traits\SqlDataRetrievable;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    use SqlDataRetrievable;
   /**
    * ProjectRepository constructor.
    *
    * @param Project $model
    */
   public function __construct(Project $model)
   {
       parent::__construct($model);
   }

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function columns(): array
    {
        if (route('projects.index')) {
            $columns = $this->columnsAsKeysAndValues(new Project(), ['updated_at'], ['user_id' => 'USER NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);
        } else {
            $columns = $this->columnsAsKeysAndValues(new Project(), ['updated_at'], ['user_id' => 'USER NAME', 'type_id' => 'TYPE NAME', 'craeted_at' => 'CRAETED At']);
        }

        return $columns;
    }

    /**
     * getColumnType
     * @return array
     */
    public function columnsTypes(): array
    {
    return $this->getColumnType(new Project(), ['id', 'created_at', 'updated_at']);
    }
}
