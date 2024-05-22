@if ($category->is_parent == true)

    @section('#tab1')
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="false">{{ __('This Children') }}</button>
    </li>
    @endsection

    @section('#tab2')
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">{{ __('All Children') }}</button>
    </li>
    @endsection

    @section('#tab3')
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false" >{{ __('This Things') }}</button>
    </li>
    @endsection

    @section('#tab4')
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false">{{ __('All Things') }}</button>
    </li>
    @endsection





    @section('tab1')
    <div class="tab-pane fade" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab" tabindex="0">
        @includeIf("$tableName.children_from_relation")
    </div>
    @endsection

    @section('tab2')
    <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab" tabindex="0">
        @includeIf("$tableName.index")
    </div>
    @endsection

    @section('tab3')
    <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab" tabindex="0">
        @includeIf("$tableName.this_non_parent")
    </div>
    @endsection

    @section('tab4')
    <div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab" tabindex="0">
        @includeIf("$tableName.non_parent")
    </div>
    @endsection



    @endif

@section('title')
    @foreach ($allParentsForThisSon as $parent)
    <span class="m-1" style="font-size: 12px">
        <span style="color: rgb(17, 218, 17)">Parent-></span><a href="{{ url($tableName."/".$parent->id) }}">{{ $parent->name }}</a>
    </span>Next
    @endforeach
@endsection

