
@php
    $tableName = request()->route()->controller->tableName;
    $modelObjectName = request()->route()->controller->modelObjectName;
    $id = request()->route("$modelObjectName.id");
@endphp



@extends('layouts.master')
@section('css')
@endsection
@section('title')
    <span class="text-muted mt-1 tx-30 mr-2 mb-0">{{ "Edit ".ucfirst($modelObjectName) }}</span>
@stop

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ ucfirst($tableName) }}</h4>
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
                                <form action="{{ route($tableName.'.update', [$modelObjectName => $id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        @foreach ($columsWithDataTypes as $column)

                                        @php
                                            $modelObjectNameValue = $column['name'];
                                        @endphp

                                        <label style="text-align: center important; display: inline-block" class="text-danger">{{ __(ucfirst($column['name'])) }}</label>
                                        @if ($column['type'] == "bigint")
                                            @if ((Str::contains($column['name'], '_id')))
                                            <select name="{{ $column['name'] }}" class="form-control SlectBox m-2">
                                                <option class="text-center" value="" selected disabled>{{ __('Choose ').ucfirst(substr($column['name'], 0, -3)) }}</option>
                                                @if ($column['name'] == 'parent_id')
                                                    @foreach (("App\Models\\".ucfirst($modelObjectName))::where('id', '!=', $id)->get() as $value)

                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id != $$modelObjectName->$modelObjectNameValue ?: 'selected' }}
                                                        >{{ $value->name }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach (("App\Models\\".ucfirst(substr($column['name'], 0, -3)))::all() as $value)

                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id != $$modelObjectName->$modelObjectNameValue ?: 'selected' }}
                                                        >{{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @endif
                                        @elseif ($column['type'] == "varchar" && $column['name'] !== "image")

                                            <input type="text"
                                            class="form-control m-2 @error($column['name']) is-invalid @enderror"
                                            name="{{ $column['name'] }}"
                                            value="{{ $$modelObjectName->$modelObjectNameValue }}"
                                            required>
                                        @elseif ($column['name'] == "image")
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">File input</label>
                                            <input name="image" class="form-control" type="file" id="formFile">
                                        </div>
                                        @elseIf ($column['name'] == "is_parent")

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <label style="text-align: center important;">{{ __('TRUE') }}</label>

                                                <input class="form-check-input text-center mr-2" name="{{ $column['name'] }}"  type="checkbox" value="{{ 0 }}" id="flexCheckChecked" {{ $$modelObjectName->$modelObjectNameValue == true ?: 'checked' }}>
                                            </div>
                                        </div>
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

