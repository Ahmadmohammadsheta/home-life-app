@props([
    'id',
    'name',
    'table',
    'object'
])

<!-- Modal -->
<div class="modal fade" id="staticBackdrop{{$id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-warning" id="staticBackdropLabel">{{ __('Warning, you will go to delete') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center"> {{ "The $object/ " }}<strong class="text-center text-danger">{{ $name }}</strong></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button form="delete{{$id}}" class="btn btn-danger">{{ __('Delete') }}</button>
                <form id="delete{{$id}}" action="{{  route($table.'.destroy', [$object => $id]) }}" method="POST">@csrf @method('DELETE')</form>
            </div>
        </div>
    </div>
</div>
