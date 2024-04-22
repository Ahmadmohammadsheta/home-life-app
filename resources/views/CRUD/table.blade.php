@php
    $modelObjectName = request()->route()->controller->modelObjectName;

    if (isset($columns)) {
        $columnsAsKeys = $columns['columnsAsKeys'];
        $columnsAsValues = $columns['columnsAsValues'];
    }else {
        $columnsAsKeys = request()->route()->controller->columnsAsKeys;
        $columnsAsValues = request()->route()->controller->columnsAsValues;
    }
@endphp
				<!-- row -->
				<div class="row">
					<!--div-->
					<div class="col-xl-12">
                        <!--AMA.Sessions div-->
                        <div class="card-header">
                            {{-- @include('layouts.includes.sessions') --}}
                        </div>
                        <!--/AMA.Sessions div-->
						<div class="card mg-b-20">
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



                            <div class="card-body">
                                <div class="table-responsive">
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
                                                    <a class="btn btn-sm btn-info" href="{{ route($tableName.'.edit', [$modelObjectName => json_encode($item->id)]) }}"><i class="las la-pen"></i></a>
                                                    <!-- Button trigger modal -->
                                                    <a type="button" class="btn btn-danger btn-sm text-light" data-toggle="modal" data-target="#exampleModal{{$item->id}}"><i
                                                        class="las la-trash"></i></a>

                                                    <a class="btn btn-sm btn-primary" href="{{ route($tableName.'.show', [$modelObjectName => json_encode($item->id)]) }}"><i class="las la-book"></i></a>
                                                </td>
                                            </tr>


                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-warning" id="exampleModalLabel">{{ __('Warning, you will go to delete') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3 class="text-center"> {{ "The $modelObjectName/ " }}<strong class="text-center text-danger">{{ $item->name }}</strong></h3>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <button form="delete{{$item->id}}" class="btn btn-danger">{{ __('Yes') }}</button>
                                                            <form id="delete{{$item->id}}" action="{{  route($tableName.'.destroy', [$modelObjectName => $item->id]) }}" method="POST">@csrf @method('DELETE')</form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
						</div>
					</div>
					<!--/div-->



				</div>
				<!-- row closed -->
