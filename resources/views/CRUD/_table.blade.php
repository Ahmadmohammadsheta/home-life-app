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
            <!--/AMA.Sessions div-->
            <div class="card-header pb-0">
                @if (Route::currentRouteName() === "$tableName.show")
                <div class="d-flex justify-content-between">
                    <a class="btn btn-primary btn-block" href="{{ route($tableName.'.create', ['id' => request()->route("$modelObjectName.id")]) }}">{{ __('ADD RELATED') }}</a>
                </div>
                @else
                <div class="d-flex justify-content-between">
                    <a class="btn btn-primary btn-block" href="{{ route($tableName.'.create') }}">{{ __('ADD') }}</a>
                </div>
                @endif
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
                            <td class="border-bottom-0 text-center">
                                <a href="{{ asset("attachments/categories/".$item->$columnsAsValue) }}" target="_blank">
                                    <img src="{{ asset("attachments/categories/".$item->$columnsAsValue) }}" alt="My Image" style="width:45px; height:30px">
                                </a>
                            </td>
                            @else

                            <td class="border-bottom-0 text-center">{{ $item->$columnsAsValue }}</td>
                            @endif

                            @endforeach

                            <td class="border-bottom-0 text-center">
                                <a class="btn btn-sm btn-info" href="{{ route($tableName.'.edit', [$modelObjectName => json_encode($item->id)]) }}"><i class="lni lni-pencil-alt"></i></a>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger btn-sm text-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$item->id}}">
                                    <i class="lni lni-trash-can"></i>
                                </button>

                                <a class="btn btn-sm btn-primary" href="{{ route($tableName.'.show', [$modelObjectName => json_encode($item->id)]) }}"><i class="lni lni-book"></i></a>
                            </td>
                        </tr>

                        <!-- Modal -->
                        @include('crud._modal')

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/div-->



    </div>
    <!-- row closed -->
