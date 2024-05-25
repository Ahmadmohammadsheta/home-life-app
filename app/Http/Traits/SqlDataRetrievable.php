<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

Trait SqlDataRetrievable
{
    /**
     *@return array
     */
    public function mysqlTables()
    {
        // return from Helpers/mysqlTables.php
        return mysqlTables(['users']);
    }

    /**
     * 1- get table name dynamically.
     *
     */
    public function tableName(Model $modelInstance)
    {
        return ($modelInstance)->getTable();
    }

    /**
     *  get table columns names dynamically.
     *
     */
    public function tableColumnNames(Model $modelInstance)
    {
        // get the table name by the Model
        $tableName = $this->tableName($modelInstance);

        // get the table columns names
        return Schema::getColumnListing($tableName);
    }

    /**
     * filter table columns names
     * if you want to prevent custom columns to show in the blade table file.
     * @param Model $modelInstance
     * @param array $exceptedData
     * @return array
     */
    public function filteredColumns(Model $modelInstance, array $exceptedData): array
    {
        // get the table columns names
        $allColumns = $this->tableColumnNames($modelInstance);

        // merge the excepted colums with the default
        $exceptedColumns = array_merge($exceptedData, ['created_at', 'updated_at', 'deleted_at']);

        // filter the array by show the columns without the all excepted
        return array_diff($allColumns, $exceptedColumns);
    }

    /**
     * get table columns names
     * @param Model $modelInstance
     * @param array $data
     * @return array
     */
    public function columnsAsKeysAndValues(Model $modelInstance, array $data): array
    {
        // filter the array by show the columns without the all excepted
        $filteredColumns = $this->filteredColumns($modelInstance, $data['excepted']);

        // rename the columns by using the original columns array by a new array has a new names but the same columns count
        $columnsAsKeys = array_combine($filteredColumns, $data['columnsAsKeys']);

        $columnsAsValues = array_combine($filteredColumns, $data['custom']);

        return [
            'columnsAsKeys' => $columnsAsKeys,
            'columnsAsValues' => $columnsAsValues
        ];
    }

    /**
     * @param Model $modelInstance
     * @param array $data
     * @return array
     * get the column type
     */
    public function getColumnType(Model $modelInstance, array $data): array
    {
        // filter the array by show the columns without the all excepted
        $filteredColumns = $this->filteredColumns($modelInstance, $data['excepted']);

        foreach ($filteredColumns as $filteredColumn) {
            $columnDataType = Schema::getColumnType($this->tableName($modelInstance), $filteredColumn);
            $columsWithDataTypes[] = (["name" => $filteredColumn, "type" => $columnDataType]);
        }
        return ($columsWithDataTypes);
    }
}
