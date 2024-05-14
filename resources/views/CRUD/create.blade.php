
@php
    $tableName = request()->route()->controller->additionalData['tableName'];
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];
    $id = request()->get('id');
@endphp

@extends('layouts.master')

@section('css')
@endsection

@section('title', "/ Create ".ucfirst($modelObjectName))

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">

            <form action="{{ route($tableName.'.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ $id }}">

                @include('crud._form', ['action' => 'Create'])

            </form>
        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
<script src="{{URL::asset('assets/js/create.js')}}"></script>
@endsection

