<?php
namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

Trait SqlDataRetrievable
{
    /**
     *
     */
    public function modelData($model)
    {
        return $model::all();
    }

    /**
     *
     */
    public function mysqlTables()
    {
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $TablesNames[] = $table->Tables_in_home_life_app;
        }
        $filterTables = array_diff($TablesNames, ['personal_access_tokens', 'password_reset_tokens', 'migrations', 'failed_jobs']);
        foreach ($filterTables as $filterTable) {
            $myTables[] = Str::upper($filterTable);
        }
        return $myTables;
    }

    /**
     * 1- get table name dynamically.
     *
     */
    public function modelTableName(Model $modelInstance)
    {
        return ($modelInstance)->getTable();
    }

    /**
     * 2- get table columns names dynamically.
     *
     */
    public function tableColumnNames(Model $modelInstance)
    {
        $tableName = $this->modelTableName($modelInstance);
        return Schema::getColumnListing($tableName);
    }

    /**
     * 3- filter table columns names
     * if you want to prevent custom columns to show in the blade table file.
     *
     */
    public function filteredTableColumnNames(Model $modelInstance, $exceptedColumns = ['created_at', 'updated_at'])
    {
        $tableColumnNames = $this->tableColumnNames($modelInstance);
        return array_diff($tableColumnNames, $exceptedColumns);
    }

    /**
     * 4- make the array key have the the columns names.
     * this to help you if you want to rename the column names in the blade table file.
     *
     */
    public function columnKeysNamesEqualColumnNames(Model $modelInstance, $exceptedColumns = ['created_at', 'updated_at'])
    {
        $keyAndValues = $this->filteredTableColumnNames($modelInstance, $exceptedColumns);
        return array_combine($keyAndValues, $keyAndValues); // Make the keys names have the same values names
    }


    /**
     * get table columns names
     *
     */
    public function theWholeMethod(Model $modelInstance, $exceptedColumns = ['created_at', 'updated_at'])
    {
        $tableName = ($modelInstance)->getTable();
        $allColumns = Schema::getColumnListing($tableName);
        $filteredColumns = array_diff($allColumns, $exceptedColumns);
        return array_combine($filteredColumns, $allColumns); // Make the keys names have the same values names
    }

    /**
     * get the column type
     */
    public function getColumnType(Model $modelInstance, $exceptedColumns = ['created_at', 'updated_at'])
    {
        $columnNames = $this->filteredTableColumnNames($modelInstance, $exceptedColumns);

        foreach ($columnNames as $columnName) {
            $columnDataType = Schema::getColumnType($this->modelTableName($modelInstance), $columnName);
            $columsWithDataTypes[] = (["name" => $columnName, "type" => $columnDataType]);
        }
        return $columsWithDataTypes;
    }



    // -----------------------------------------------------------------Another structure---------------------
    // -----------------------------------------------------------------Another structure---------------------
    // -----------------------------------------------------------------Another structure---------------------

    /**
     * 3- filter table columns names
     * if you want to prevent custom columns to show in the blade table file.
     *
     */
    public function filteredTableColumnNames2(Model $modelInstance, $exceptedColumns = ['created_at', 'updated_at'])
    {
        $tableName = ($modelInstance)->getTable();
        $all_columns = Schema::getColumnListing($tableName);
        return array_diff($all_columns, $exceptedColumns);
    }

    /**
     * 4- make the array key have the the columns names.
     * this to help you if you want to rename the column names in the blade table file.
     *
     */
    public function columnKeysNamesEqualColumnNames2(Model $modelInstance, $exceptedColumns = ['created_at', 'updated_at'])
    {
        return array_combine($this->filteredTableColumnNames($modelInstance, $exceptedColumns), $this->filteredTableColumnNames($modelInstance, $exceptedColumns)); // Make the keys names have the same values names
    }





    /**
     * Display a listing of the resource.
     */
    public function columnsAsKeysAndValues(Model $modelInstance, array $exceptedColumns = ['updated_at'], array $renameColumns = ['created_at' => 'CREATED AT'])
    {
        $columnsAsValues = $this->filteredTableColumnNames($modelInstance, $exceptedColumns);
        $columnsAsKeys = $this->columnKeysNamesEqualColumnNames($modelInstance, $exceptedColumns);
        foreach ($columnsAsKeys as $columnsAsKey) {
            foreach ($renameColumns as $key =>$value) {
                if ($columnsAsKey == $key) {
                    $columnsAsKeys[$key] = $value;
                }
            }
        }

        return ['columnsAsKeys' => $columnsAsKeys, 'columnsAsValues' => $columnsAsValues];

    }

}
