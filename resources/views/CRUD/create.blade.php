
@php
    $tableName = request()->route()->controller->additionalData['tableName'];
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];
    $id = request()->get('id');
@endphp

@extends('layouts.master')

@section('css')
@endsection

@section('title')
{{ "/ Create ".ucfirst($modelObjectName) }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ ucfirst($tableName)}}</h4>
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

            <form action="{{ route($tableName.'.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ $id }}">

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

    <script>

        //-----------------------------------------------------------------------------------------------------------
        // AMA. related product section ajax
        // working
        $(document).ready(function() {
            var categoryId = $('input[name="id"]').val();
            if (categoryId) {
                $.ajax({
                    url: "{{ URL::to('categories/') }}/" + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // alert(data.category);
                        $('select[name="parent_id"]').empty();

                        $('select[name="parent_id"]').append('<option value="' +
                        data.category.id + '">' + data.category.name + '</option>');

                        $('select[name="type_id"]').empty();

                        $('select[name="type_id"]').append('<option value="' +
                        data.category.type.id + '">' + data.category.type.name + '</option>');
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }

        });
        //__________________________________________________________________________________________________________

        //-----------------------------------------------------------------------------------------------------------
        // AMA. related product section ajax
        // working
        $(document).ready(function() {
            $('select[name="parent_id"]').on('change', function() {
                var parentId = $(this).val();
                if (parentId) {
                    $.ajax({
                        url: "{{ URL::to('categories/') }}/" + parentId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="type_id"]').empty();
                            // $.each(data, function(index, value) {
                                // alert(data.data.id);
                                $('select[name="type_id"]').append('<option value="' +
                                data.type.id + '">' + data.type.name + '</option>');
                            // });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
        //__________________________________________________________________________________________________________

    </script>
@endsection

