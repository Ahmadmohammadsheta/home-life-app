<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

Trait GetSqlDataTrait
{
    /**
     * get table name dynamically.
     *
     */
    public function modelTableName(Model $model_object)
    {
        $table_name = ($model_object)->getTable();
        return $table_name;
    }
    /**
     * get table columns names dynamically.
     *
     */
    public function tableColumnNames(Model $model_object)
    {
        $all_columns = Schema::getColumnListing($this->modelTableName($model_object));
        return $all_columns;
    }

    /**
     * filter table columns names
     * if you want to prevent custom columns to show in the blade table file.
     *
     */
    public function filteredTableColumnNames(Model $model_object, $excepted_columns= ['created_at', 'updated_at'])
    {
        $filtered_columns = array_diff($this->tableColumnNames($model_object), $excepted_columns);
        return $filtered_columns;
    }

    /**
     * make the array key have the the columns names.
     * this to help you if you want to rename the column names in the blade table file.
     *
     */
    public function columnKeysNamesEqualColumnNames(Model $model_object, $excepted_columns= ['created_at', 'updated_at'])
    {
        $columns = array_combine($this->filteredTableColumnNames($model_object, $excepted_columns), $this->filteredTableColumnNames($model_object, $excepted_columns)); // Make the keys names have the same values names
        return $columns;
    }


    /**
     * get table columns names
     *
     */
    public function theAllMethod(Model $model_object, $excepted_columns= ['created_at', 'updated_at'])
    {
        $table_name = ($model_object)->getTable();
        $all_columns = Schema::getColumnListing($table_name);
        $columns = array_combine($all_columns, $all_columns); // Make the keys names have the same values names
        $filtered_columns = array_diff($columns, $excepted_columns);
        return $filtered_columns;
    }
}
