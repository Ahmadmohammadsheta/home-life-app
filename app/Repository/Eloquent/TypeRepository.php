<?php

namespace App\Repository\Eloquent;

use App\Models\Type;
use App\Repository\TypeRepositoryInterface;
use App\Http\Traits\SqlDataRetrievable;

class TypeRepository extends BaseRepository implements TypeRepositoryInterface
{
    use SqlDataRetrievable;
   /**
    * TypeRepository constructor.
    *
    * @param Type $model
    */
   public function __construct(Type $model)
   {
       parent::__construct($model);
   }

   /**
    * columnsAsKeysAndValues
    * @return array
    */
    public function columns(): array
    {
        $data = [
            'custom' => ['id', 'name'],
            'columnsAsKeys' => ['id', 'name'],
            'excepted' => [],
        ];
        if (route('categories.index')) {
            $columns = $this->columnsAsKeysAndValues(new Type(), $data);
        } else {
            $columns = $this->columnsAsKeysAndValues(new Type(), $data);
        }
        // if (route('types.index')) {
        //     $columns = $this->columnsAsKeysAndValues(new Type(), ['updated_at'], ['created_at' => 'CREATED At']);
        // } else {
        //     $columns = $this->columnsAsKeysAndValues(new Type(), ['updated_at'], ['user_id' => 'USER NAME', 'type_id' => 'TYPE NAME', 'created_at' => 'CRAETED At']);
        // }

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
         return $this->getColumnType(new Type(), $data);
     }
}
