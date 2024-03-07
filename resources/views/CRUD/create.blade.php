@extends('layouts.master')
@section('css')
@endsection
@section('title')
    <span class="text-muted mt-1 tx-30 mr-2 mb-0">{{ "Create New ".ucfirst($modelObjectName) }}</span>
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
                                <form action="{{ route($tableName.'.store') }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        @foreach ($columsWithDataTypes as $column)

                                        <label style="text-align: center important; display: inline-block" class="text-danger">{{ __(ucfirst($column['name'])) }}</label>
                                        @if ($column['type'] == "bigint")
                                            @if ((Str::contains($column['name'], '_id')))
                                            <select name="{{ $column['name'] }}" class="form-control SlectBox m-2">
                                                <option class="text-center" value="" selected disabled>{{ __('Choose ').ucfirst(substr($column['name'], 0, -3)) }}</option>
                                                @if ($column['name'] == 'parent_id')
                                                    @foreach (("App\Models\\".ucfirst($modelObjectName))::all() as $value)
                                                    @php
                                                        $modelObjectNameValue = $column['name'];
                                                    @endphp
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach (("App\Models\\".ucfirst(substr($column['name'], 0, -3)))::all(); as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @endif
                                        @elseif ($column['type'] == "varchar" && $column['name'] !== "image")
                                            <input type="text" class="form-control m-2 @error($column['name']) is-invalid @enderror" name="{{ $column['name'] }}" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @elseif ($column['name'] == "image")
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Default file input example</label>
                                            <input name="image" class="form-control" type="file" id="formFile">
                                          </div>
                                        {{-- <input type="file" name="image" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                        data-height="70" /> --}}
                                            {{-- <input type="file" name="{{ $column['name'] }}" class="form-control m-2"> --}}
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

