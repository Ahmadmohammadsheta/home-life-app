<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

Trait GetSqlDataTrait
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
    public function modelTableName(Model $model_object)
    {
        return ($model_object)->getTable();
    }
    /**
     * 2- get table columns names dynamically.
     *
     */
    public function tableColumnNames(Model $model_object)
    {
        return Schema::getColumnListing($this->modelTableName($model_object));
    }

    /**
     * 3- filter table columns names
     * if you want to prevent custom columns to show in the blade table file.
     *
     */
    public function filteredTableColumnNames(Model $model_object, $excepted_columns = ['created_at', 'updated_at'])
    {
        return array_diff($this->tableColumnNames($model_object), $excepted_columns);
    }

    /**
     * 4- make the array key have the the columns names.
     * this to help you if you want to rename the column names in the blade table file.
     *
     */
    public function columnKeysNamesEqualColumnNames(Model $model_object, $excepted_columns = ['created_at', 'updated_at'])
    {
        return array_combine($this->filteredTableColumnNames($model_object, $excepted_columns), $this->filteredTableColumnNames($model_object, $excepted_columns)); // Make the keys names have the same values names
    }


    /**
     * get table columns names
     *
     */
    public function theWholeMethod(Model $model_object, $excepted_columns = ['created_at', 'updated_at'])
    {
        $table_name = ($model_object)->getTable();
        $all_columns = Schema::getColumnListing($table_name);
        $filtered_columns = array_diff($all_columns, $excepted_columns);
        $columns = array_combine($filtered_columns, $all_columns); // Make the keys names have the same values names
        return $filtered_columns;
    }



    /**
     * 3- filter table columns names
     * if you want to prevent custom columns to show in the blade table file.
     *
     */
    public function filteredTableColumnNames2(Model $model_object, $excepted_columns = ['created_at', 'updated_at'])
    {
        $table_name = ($model_object)->getTable();
        $all_columns = Schema::getColumnListing($table_name);
        return array_diff($all_columns, $excepted_columns);
    }

    /**
     * 4- make the array key have the the columns names.
     * this to help you if you want to rename the column names in the blade table file.
     *
     */
    public function columnKeysNamesEqualColumnNames2(Model $model_object, $excepted_columns = ['created_at', 'updated_at'])
    {
        return array_combine($this->filteredTableColumnNames($model_object, $excepted_columns), $this->filteredTableColumnNames($model_object, $excepted_columns)); // Make the keys names have the same values names
    }


}
