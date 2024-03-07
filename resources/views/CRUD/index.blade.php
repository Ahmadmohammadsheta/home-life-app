@extends('layouts.master')

@section('title')
    <span class="text-muted mt-1 tx-30 mr-2 mb-0">{{ "All ".ucfirst($tableName) }}</span>
@stop


@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
{{ __(ucfirst($tableName)) }}
@endsection

@section('content')
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
                                <div class="d-flex justify-content-between">
                                    <a class="btn btn-primary btn-block" href="{{ route($tableName.'.create') }}">{{ __('ADD') }}</a>
                                </div>
                            </div>



                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table key-buttons text-md-nowrap">
                                        <thead>
                                            <tr>
                                                @foreach ($columns as $column)
                                                <th class="border-bottom-0 text-center text-danger">{{ $column }}</th>
                                                @endforeach
                                                <th class="border-bottom-0 text-center text-danger">{{ __('OPERATIONS') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (json_decode($data) as $item)
                                            <tr>
                                                @foreach ($filterColumnNames as $filterColumnName)
                                                @if ($filterColumnName == "image")
                                                <td class="border-bottom-0 text-center">
                                                    <a href="{{ asset($item->$filterColumnName) }}" target="_blank">
                                                        <img src="{{ asset($item->$filterColumnName) }}" alt="My Image">
                                                    </a>
                                                </td>
                                                @else
                                                <td class="border-bottom-0 text-center">{{ $item->$filterColumnName }}</td>
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
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

{{-- @include('sections.scripts.edit')
@include('sections.scripts.delete') --}}
@endsection
