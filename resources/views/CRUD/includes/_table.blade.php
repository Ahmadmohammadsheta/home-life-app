@php
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];

    if (isset($columns)) {
        $columnsAsKeys = $columns['columnsAsKeys'];
        $columnsAsValues = $columns['columnsAsValues'];
    }
@endphp
    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <x-table.header
                :table="$tableName"
                :object="$modelObjectName"
                :first="[
                    'route' => 'create',
                    'name' => 'ADD',
                    'color' => 'primary'
                    ]"
                :second="
                    [
                    'route' => 'trashed',
                    'name' => 'TRASHED',
                    'color' => 'danger'
                    ]"
            />

            <x-table.table
                component="table"
                :data="$data"
                :keys="$columnsAsKeys"
                :values="$columnsAsValues"
                :table="$tableName"
                :object="$modelObjectName"
            />
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
