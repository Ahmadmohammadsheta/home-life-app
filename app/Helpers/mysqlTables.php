<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


    /**
    * Write code on Method
    *
    * @return response()
    */
    if (! function_exists('mysqlTables')) {
        function mysqlTables()
        {
            $tables = DB::select('SHOW TABLES');
            foreach ($tables as $table) {
                $TablesNames[] = $table->Tables_in_home_life_app;
            }
            $filterTables = array_diff($TablesNames, ['users', 'personal_access_tokens', 'password_reset_tokens', 'migrations', 'failed_jobs']);
            foreach ($filterTables as $filterTable) {
                $myTables[] = Str::upper($filterTable);
            }
            return $myTables;
        }
    }
