
@php
    $tableName = request()->route()->controller->additionalData['tableName'];
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];

    if (isset($columns)) {
        $columnsAsKeys = $columns['columnsAsKeys'];
        $columnsAsValues = $columns['columnsAsValues'];
    }
@endphp

@extends('layouts.master')

@includeIf("$tableName.show", ['page' => 'name'])

@section('title', "/Show ".ucfirst($modelObjectName))

@section('css')
@endsection

@section('content')
<!-- row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card-body">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ ucfirst($modelObjectName) }}</button>
                    </li>
                    @yield('#tab1')
                    @yield('#tab2')
                    @yield('#tab3')
                    @yield('#tab4')
                </ul>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="col-12 col-md-4">
                        <div class="card border-0">
                            <div class="card-body py-4">
                                @foreach ($columnsAsValues as $columnsAsValue)
                                @if (!in_array($columnsAsValue, ["image", "parentName"]))
                                <div class="mb-0">
                                    <span class="badge text-success me-2">{{ "The $columnsAsValue" }}</span>
                                    <span class="fw-bold">{{ (($$modelObjectName[$columnsAsValue])) }}</span>
                                </div>

                                @endif

                                @if ($columnsAsValue == "parentName")
                                <a href="{{ url($tableName."/".$$modelObjectName['parent_id']) }}">
                                    <div class="mb-0">
                                        <span class="badge text-success me-2">{{ "The $columnsAsValue" }}</span>
                                        <span class="fw-bold">{{ (($$modelObjectName[$columnsAsValue])) }}</span>
                                    </div>
                                </a>
                                @endif

                                @endforeach
                            </div>
                        </div>

                        @foreach ($columnsAsValues as $columnsAsValue)
                        @if ($columnsAsValue == "image")
                        <div class="border-bottom-0 text-center" style="width: 240px; hieght:180px">
                            <a href="{{ asset($$modelObjectName[$columnsAsValue]) }}" target="_blank">
                                <img src="{{ (asset($$modelObjectName[$columnsAsValue])) }}" alt="My Image">
                            </a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                @yield('tab1')

                @yield('tab2')

                @yield('tab3')

                @yield('tab4')
            </div>
        </div>
    <!-- /div -->
    </div>
</div>
<!-- row closed -->
@endsection


@section('js')

@endsection
