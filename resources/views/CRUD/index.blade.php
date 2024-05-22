
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

    @if (View::exists("$tableName.index")) @include("$tableName.index") @else @include('crud.includes._table') @endif
    
    <!-- row closed -->
@endsection

@section('js')

@endsection
