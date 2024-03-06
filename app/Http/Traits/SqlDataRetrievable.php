<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

Trait SqlDataRetrievable
{
    /**
     * 1- get table name dynamically.
     *
     */
    public function modelData($model)
    {
        return $model::all();
    }
    /**
     * 1- get table name dynamically.
     *
     */
    public function modelTableName(Model $modelObject)
    {
        return ($modelObject)->getTable();
    }
    /**
     * 2- get table columns names dynamically.
     *
     */
    public function tableColumnNames(Model $modelObject)
    {
        return Schema::getColumnListing($this->modelTableName($modelObject));
    }

    /**
     * 3- filter table columns names
     * if you want to prevent custom columns to show in the blade table file.
     *
     */
    public function filteredTableColumnNames(Model $modelObject, $exceptedColumns = ['created_at', 'updated_at'])
    {
        return array_diff($this->tableColumnNames($modelObject), $exceptedColumns);
    }

    /**
     * 4- make the array key have the the columns names.
     * this to help you if you want to rename the column names in the blade table file.
     *
     */
    public function columnKeysNamesEqualColumnNames(Model $modelObject, $exceptedColumns = ['created_at', 'updated_at'])
    {
        return array_combine($this->filteredTableColumnNames($modelObject, $exceptedColumns), $this->filteredTableColumnNames($modelObject, $exceptedColumns)); // Make the keys names have the same values names
    }


    /**
     * get table columns names
     *
     */
    public function theWholeMethod(Model $modelObject, $exceptedColumns = ['created_at', 'updated_at'])
    {
        $tableName = ($modelObject)->getTable();
        $allColumns = Schema::getColumnListing($tableName);
        $filteredColumns = array_diff($allColumns, $exceptedColumns);
        return array_combine($filteredColumns, $allColumns); // Make the keys names have the same values names
    }

    /**
     * get the column type
     */
    public function getColumnType(Model $modelObject, $exceptedColumns = ['created_at', 'updated_at'])
    {
        $columnNames = $this->filteredTableColumnNames($modelObject, $exceptedColumns);

        foreach ($columnNames as $columnName) {
            $columsWithDataTypes[] = (["name" => $columnName, "type" => Schema::getColumnType($this->modelTableName($modelObject), $columnName)]);
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
    public function filteredTableColumnNames2(Model $modelObject, $exceptedColumns = ['created_at', 'updated_at'])
    {
        $table_name = ($modelObject)->getTable();
        $all_columns = Schema::getColumnListing($table_name);
        return array_diff($all_columns, $exceptedColumns);
    }

    /**
     * 4- make the array key have the the columns names.
     * this to help you if you want to rename the column names in the blade table file.
     *
     */
    public function columnKeysNamesEqualColumnNames2(Model $modelObject, $exceptedColumns = ['created_at', 'updated_at'])
    {
        return array_combine($this->filteredTableColumnNames($modelObject, $exceptedColumns), $this->filteredTableColumnNames($modelObject, $exceptedColumns)); // Make the keys names have the same values names
    }

}
