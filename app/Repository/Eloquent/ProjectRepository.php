<?php

namespace App\Repository\Eloquent;

use App\Models\Type;
use App\Models\Project;
use App\Http\Traits\SqlDataRetrievable;
use App\Repository\ProjectRepositoryInterface;

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
        $data = [
            'excepted' => ['id', 'created_at', 'updated_at']
        ];
    return $this->getColumnType(new Project(), $data);
    }

    /**
     * getColumnType
     * @param id $categoryId
     * @return array
     */
     public function arrayForSelectInput(): array
     {

         $types = (new TypeRepository(new Type))->all();

         $arrayForSelectInput = [
             [
                 'data' => $types,
                 'to' =>'type_id'
             ],
         ];
         return $arrayForSelectInput;
         // $error = throw new InvalidArgumentException();
     }
}
