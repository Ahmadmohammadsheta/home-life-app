@php
    $modelObjectName = request()->route()->controller->additionalData['modelObjectName'];

    if (isset($columns)) {
        $columnsAsKeys = $columns['columnsAsKeys'];
        $columnsAsValues = $columns['columnsAsValues'];
    }
@endphp
    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card-header pb-0">

                <x-table.header :table="$tableName" :object="$modelObjectName" />

            </div>

            <div class="table table-responsive table-stripped">
                <table id="example1" class="table key-buttons text-md-nowrap">
                    <thead>
                        <tr>
                            @foreach ($columnsAsKeys as $columnsAsKey)
                            <th class="border-bottom-0 text-center text-danger">{{ $columnsAsKey }}</th>
                            @endforeach
                            <th class="border-bottom-0 text-center text-danger">{{ __('OPERATIONS') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            @foreach ($columnsAsValues as $columnsAsValue)

                            @if ($columnsAsValue == "image")
                            <td @class([
                                'border-bottom-0',
                                'text-center '
                            ])
                            >
                                <a href="{{ asset($item->$columnsAsValue) }}" target="_blank">
                                    <img src="{{ asset($item->$columnsAsValue) }}" alt="My Image" style="width:45px; height:30px">
                                </a>
                            </td>
                            @else

                            <td @class([
                                    'border-bottom-0',
                                    'text-center ',
                                    'text-danger' => $item->$columnsAsValue === false ? true : false,
                                    'text-success' => $item->$columnsAsValue === true ? true : false,
                                    // 'font-bold' => true
                                ])
                                >
                                {{ $item->$columnsAsValue === true ? 'True' : ($item->$columnsAsValue === false ? 'False' : $item->$columnsAsValue) }}
                            </td>
                            @endif

                            @endforeach

                            <td @class([
                                'border-bottom-0',
                                'text-center '
                            ])
                            >

                                <x-table.actions :id="$item->id" :table="$tableName" :object="$modelObjectName" />
                            </td>
                        </tr>

                        <!-- Modal -->

                        <x-table.modal :id="$item->id" :name="$item->name" :table="$tableName" :object="$modelObjectName" />

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/div-->



    </div>
    <!-- row closed -->
