@section('#tab5')
<li><a href="#tab5" class="nav-link" data-toggle="tab">{{ __('This Children') }}</a></li>
@endsection

@section('#tab6')
<li><a href="#tab6" class="nav-link" data-toggle="tab">{{ __('All Children') }}</a></li>
@endsection

@section('#tab7')
<li><a href="#tab7" class="nav-link" data-toggle="tab">{{ __('This Things') }}</a></li>
@endsection

@section('#tab8')
<li><a href="#tab8" class="nav-link" data-toggle="tab">{{ __('All Things') }}</a></li>
@endsection





@section('tab5')
<div class="table-responsive mt-15">

    <div class="card card-statistics">
        @includeIf("CRUD.$tableName.children_from_relation")
    </div>
</div>
@endsection

@section('tab6')
<div class="card card-statistics">
    @includeIf("CRUD.$tableName.index")
</div>
@endsection

@section('tab7')
<div class="card card-statistics">
    @includeIf("CRUD.$tableName.this_non_parent")
</div>
@endsection

@section('tab8')
<div class="card card-statistics">
    @includeIf("CRUD.$tableName.non_parent")
</div>
@endsection
