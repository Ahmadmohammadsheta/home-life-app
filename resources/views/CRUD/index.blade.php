
@php
    $tableName = request()->route()->controller->additionalData['tableName'];
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];

@endphp

@extends('layouts.master')

@section('title', "/ All ".ucfirst($tableName))

@section('css')
@endsection

@section('content')
    <!-- row -->

    @if (View::exists("$tableName.index"))
        @include("$tableName.index")
    @else
        @include('crud.includes._table',
        [
            'component' => 'table',
            'first'=> [
                'route' => 'create',
                'name' => 'CREATE',
                'color' => 'primary'
                ],
            'second' =>
                [
                'route' => 'trashed',
                'name' => 'TRASHED',
                'color' => 'danger'
                ]
            ])
    @endif

    <!-- row closed -->
@endsection

@section('js')

@endsection
