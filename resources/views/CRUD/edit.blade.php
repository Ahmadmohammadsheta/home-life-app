
@php
    $tableName = request()->route()->controller->additionalData['tableName'];
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];
    $id = request()->route("$modelObjectName.id");
@endphp

@extends('layouts.master')

@section('css')
@endsection

@section('title', "/ Edit ".ucfirst($modelObjectName))

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">

            <form action="{{ route($tableName.'.update', [$modelObjectName => $id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('crud._form', ['action' => 'Update'])
            </form>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
@endsection

