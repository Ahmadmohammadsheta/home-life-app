@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h3 class="fw-bold fs-4 mb-0">{{ __("Pages:/ ") }}</h3>
                            <h3 class="fw-bold fs-4 mb-0 text_success">{{ __("Admin Dashboard") }}</h3>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card border-0">
                <div class="card-body py-4">
                    <h5 class="mb-2 fw-bold">Member Progress</h5>
                    <p class="mb-2 fw-bold">paragraph</p>
                    <div class="mb-0">
                        <span class="badge text_success me-2">span</span>
                        <span class="fw-bold">Bold span</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0">
                <div class="card-body py-4">
                    <h5 class="mb-2 fw-bold">Member Progress</h5>
                    <p class="mb-2 fw-bold">paragraph</p>
                    <div class="mb-0">
                        <span class="badge text_success me-2">span</span>
                        <span class="fw-bold">Bold span</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0">
                <div class="card-body py-4">
                    <h5 class="mb-2 fw-bold">Member Progress</h5>
                    <p class="mb-2 fw-bold">paragraph</p>
                    <div class="mb-0">
                        <span class="badge text_success me-2">span</span>
                        <span class="fw-bold">Bold span</span>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="fw-bold fs-4 my-3">Avg</h3>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr class="highlight">
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
@endsection
