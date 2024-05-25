@props([
    'data',
    'keys',
    'values',
    'table',
    'object',
    'component' => 'table'
])


<div class="table table-responsive table-stripped">
    <table id="example1"
        {{ $attributes->class([
            'table',
            'key-buttons',
            'text-md-nowrap'
        ]) }}
    >
        <thead>
            <tr>
                @foreach ($keys as $key)
                <x-table.td type="th" class=" text-danger"> {{ $key }} </x-table.td>
                @endforeach
                <x-table.td type="th" class=" text-danger"> {{ __('OPERATIONS') }} </x-table.td>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                @foreach ($values as $value)

                <x-table.td :columnValue="$item->$value" :columnAsValue="$value" />

                @endforeach

                @if ($component == 'table')
                <x-table.td>
                    <!-- redirection show button -->
                    <x-general.anchor
                        color="primary"
                        size="sm"
                        :href="route($table.'.show', [$object => $item->id])"
                        icon="book"
                    />

                    <!-- redirection edit button -->
                    <x-general.anchor
                        color="info"
                        size="sm"
                        :href="route($table.'.edit', [$object => $item->id])"
                        icon="pencil-alt"
                    />

                    <!-- Button trigger modal to submit the deletion -->
                    <x-general.anchor data-bs-toggle="modal" data-bs-target="#{{$item->name.$item->id}}"
                        color="danger"
                        size="sm"
                        icon="trash-can"
                    />
                </x-table.td>
                @else

                <x-table.td class="text-center">
                    <div class="d-flex justify-content-center">
                        <!-- restore button -->
                        <x-general.form-as-button class="mx-2"
                            method="PUT"
                            :action="route($table.'.restore', [$object => $item->id])"
                            actionType="restore"
                            :id="$item->id"
                            color="primary"
                            icon="pencil-alt"
                            size="sm"
                        >
                        {{ __('Restore') }}
                        </x-general.form-as-button>

                        <!-- Button trigger modal to submit the deletion -->
                        <x-general.anchor data-bs-toggle="modal" data-bs-target="#{{$item->name.$item->id}}"
                            color="danger"
                            size="sm"
                            icon="trash-can"
                        >
                        {{ __('Delete') }}
                        </x-general.anchor>

                    </div>
                </x-table.td>

                @endif

            </tr>

            <!-- Modal -->

            <x-table.modal
                :modalId="$item->name.$item->id"
                :id="$item->id"
                :name="$item->name"
                :table="$table"
                :object="$object"
                route="{{ $component == 'table' ? 'destroy' : 'force-delete' }}"
            />

            @endforeach
        </tbody>
    </table>

    {{ str_contains(Route::currentRouteAction(), 'index') ? $data->withQueryString()->links() : '' }}

</div>
