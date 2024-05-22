<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


    /**
    * Write code on Method
    *
    * @return response()
    */
    if (! function_exists('mysqlTables')) {
        function mysqlTables(array $exception = [])
        {
            // return tables dynamically AMA
            $tables = DB::select('SHOW TABLES');
            foreach ($tables as $table) {
                $TablesNames[] = $table->Tables_in_home_life_app;
            }
            $exception = array_merge($exception, ['personal_access_tokens', 'password_reset_tokens', 'migrations', 'failed_jobs']);
            $filterTables = array_diff($TablesNames, $exception);
            foreach ($filterTables as $filterTable) {
                $myTables[] = Str::upper($filterTable);
            }

            // this is the manual tables array as [table => icon] AMA
            $myTables = [
                'Categories' => 'layout',
                'Types' => 'vector',
                'Project' => 'rocket',
                'Members' => 'network',
                // 'Position' => ''
            ];

            return $myTables;
        }
    }
