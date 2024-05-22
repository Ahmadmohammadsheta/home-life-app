@props([
    'id',
    'table',
    'object'
])


<!-- redirection show button -->
<a class="btn btn-sm btn-primary"
href="{{ route($table.'.show', [$object => $id]) }}">
    <i class="lni lni-book"></i>
</a>

<!-- redirection edit button -->
<a class="btn btn-sm btn-info"
href="{{ route($table.'.edit', [$object => $id]) }}">
    <i class="lni lni-pencil-alt"></i>
</a>

<!-- Button trigger modal to submit the deletion -->
<button type="button" class="btn btn-danger btn-sm text-light"
data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$id}}">
    <i class="lni lni-trash-can"></i>
</button>
