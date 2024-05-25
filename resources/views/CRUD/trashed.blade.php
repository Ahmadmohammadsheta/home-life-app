
@php
$tableName = request()->route()->controller->additionalData['tableName'];
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];

    if (isset($columns)) {
        $columnsAsKeys = $columns['columnsAsKeys'];
        $columnsAsValues = $columns['columnsAsValues'];
    }
@endphp
@extends('layouts.master')

@section('title', "/ Trashed ".ucfirst($tableName))

@section('css')
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">

            <x-table.header
                :table="$tableName"
                :object="$modelObjectName"
                :first="[
                    'route' => 'index',
                    'name' => 'NOT TRASHED',
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
                component="tableForTrashed"
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
@endsection

@section('js')

@endsection
