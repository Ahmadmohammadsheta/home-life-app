
@php
    $tableName = request()->route()->controller->additionalData['tableName'];
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];
    $id = request()->route("$modelObjectName.id");
@endphp

@extends('layouts.master')

@section('css')
@endsection

@section('title')
{{ "/ Edit ".ucfirst($modelObjectName) }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ ucfirst($tableName) }}</h4>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">

            @if ($errors->any())
                {{-- @include('crud._errors') --}}
            @endif

            <form action="{{ route($tableName.'.update', [$modelObjectName => $id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('crud._form')

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">{{ __('Done') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
@endsection

