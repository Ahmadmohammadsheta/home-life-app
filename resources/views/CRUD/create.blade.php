
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

                @include('crud.includes._form', ['action' => 'Create'])

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
            url: "{{ URL::to('categories') }}/" + categoryId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                // alert(categoryId);
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

    $.ajax({
            url: "{{ URL::to('types') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {

                var selectedTypeId = $('select[name="type_id"]').val();

                $.each(data, function(index, value) {
                    if (value.id != selectedTypeId) {
                        $('select[name="type_id"]').append('<option value="' +
                        value.id + '">' + value.name + '</option>');
                    }
                });
            }
        });

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
                        data.category.type.id + '">' + data.category.type.name + '</option>');
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
<script src="{{ URL::asset('assets/js/create.js') }}"></script>
@endsection

