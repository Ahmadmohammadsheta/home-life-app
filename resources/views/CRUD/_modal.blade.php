
<!-- Modal -->
<div class="modal fade" id="staticBackdrop{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-warning" id="staticBackdropLabel">{{ __('Warning, you will go to delete') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center"> {{ "The $modelObjectName/ " }}<strong class="text-center text-danger">{{ $item->name }}</strong></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button form="delete{{$item->id}}" class="btn btn-danger">{{ __('Delete') }}</button>
                <form id="delete{{$item->id}}" action="{{  route($tableName.'.destroy', [$modelObjectName => $item->id]) }}" method="POST">@csrf @method('DELETE')</form>
            </div>
        </div>
    </div>
</div>


{{--
<div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning" id="exampleModalLabel">{{ __('Warning, you will go to delete') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center"> {{ "The $modelObjectName/ " }}<strong class="text-center text-danger">{{ $item->name }}</strong></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button form="delete{{$item->id}}" class="btn btn-danger">{{ __('Yes') }}</button>
                <form id="delete{{$item->id}}" action="{{  route($tableName.'.destroy', [$modelObjectName => $item->id]) }}" method="POST">@csrf @method('DELETE')</form>
            </div>
        </div>
    </div>
</div> --}}
