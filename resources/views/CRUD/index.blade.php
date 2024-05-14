
@php
    $tableName = request()->route()->controller->additionalData['tableName'];
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];

@endphp

@extends('layouts.master')

@section('title')
{{ "/ All ".ucfirst($tableName) }}
@endsection

@section('css')
@endsection

@section('page-header', ucfirst($tableName))

@section('content')
    <!-- row -->
    @if (View::exists("crud.$tableName.index")) @include("crud.$tableName.index") @else @include('crud._table') @endif
    <!-- row closed -->
@endsection

@section('js')

@endsection
