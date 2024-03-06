@extends('layouts.master')
@section('css')
@endsection
@section('title')
    @php
    $model = substr($tableName, 0, -1);
    @endphp
    <span class="text-muted mt-1 tx-30 mr-2 mb-0">{{ "Create New ".ucfirst($model) }}</span>
@stop
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
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route($tableName.'.store') }}" method="post" id="addForm">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        @foreach ($columns as $column)

                                        <label style="text-align: center important; display: inline-block" class="text-danger">{{ __(ucfirst($column['name'])) }}</label>
                                        @if ($column['type'] == "bigint")
                                            @if ((Str::contains($column['name'], '_id')))
                                            <select name="{{ $column['name'] }}" class="form-control SlectBox m-2">
                                                <option class="text-center" value="" selected disabled>{{ __('Choose ').ucfirst(substr($column['name'], 0, -3)) }}</option>
                                                @foreach (("App\Models\\".ucfirst(substr($column['name'], 0, -3)))::all(); as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        @elseif ($column['type'] == "varchar")

                                            <input type="text" class="form-control m-2 @error($column['name']) is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @endif
                                        @endforeach

                                        @error($column['name'])
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success">{{ __('Done') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
				</div>
				<!-- row closed -->
@endsection
@section('js')
@endsection

