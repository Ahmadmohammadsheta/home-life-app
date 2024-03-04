
<div class="card-header pb-0">
    <div class="d-flex justify-content-between">
        <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-xl-t-0">
            {{-- @can('role-create') --}}
            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-newspaper" data-toggle="modal"
            href="#modaldemo8">{{ __('Add New ') }}@yield('title')</a>
            {{-- @endcan --}}
        </div>
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
                    @foreach ($filter_column_names as $filter_column_name)
                    <td class="border-bottom-0 text-center">{{ $item->$filter_column_name }}</td>
                    @endforeach

                    <td class="border-bottom-0 text-center">
                        {{-- @can('role-edit') --}}
                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-toggle="modal"
                                href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>
                        {{-- @endcan

                        @can('role-delete') --}}
                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                    class="las la-trash"></i></a>
                        {{-- @endcan --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
