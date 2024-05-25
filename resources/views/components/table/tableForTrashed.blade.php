@props([
    'data',
    'keys',
    'values',
    'table',
    'object',
])


<div class="table table-responsive table-stripped">
    <table id="example1" {{ $attributes->class([
        'table',
        'key-buttons',
        'text-md-nowrap'
    ]) }}

    >
        <thead>
            <tr>
                @foreach ($keys as $key)
                <th  class="border-bottom-0 text-center text-danger">{{ $key }}</th>
                @endforeach
                <th  class="border-bottom-0 text-center text-danger">{{ 'OPERATIONS'}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                @foreach ($values as $value)
                <td  class="border-bottom-0 text-center {{ $item->$value === false ? 'text-danger' : ($item->$value == 'True' ? 'text-success' : '') }}">
                    @if ($value == 'image')
                    <a href="{{ asset($item->$value) }}" target="_blank">
                        <img src="{{ asset($item->$value) }}" alt="My Image" style="width:45px; height:30px">
                    </a>
                    @else
                    {{ $item->$value === true ? 'True' : ($item->$value === false ? 'False' : $item->$value) }}
                    @endif
                </td>
                @endforeach

                <td  class="border-bottom-0 text-center">

                    <!-- redirection edit button -->
                    <x-general.anchor
                        color="info"
                        size="sm"
                        :href="route($table.'.edit', [$object => $item->id])"
                        icon="pencil-alt"
                    />

                    <!-- Button trigger modal to submit the deletion -->
                    <x-general.anchor data-bs-toggle="modal" data-bs-target="#{{ $item->name.$item->id }}"
                        color="danger"
                        size="sm"
                        icon="trash-can"
                    />
                    @props([
                        'type' => '',
                        'method' => 'DELETE',
                        'action' => '',
                        'actionType' => 'delete',
                        'id' => '',
                        'color' => 'primary'
                    ])
                    <!-- redirection show button -->
                    <x-general.form-as-button
                        metho="Update"
                        :action="route($table.'.restore', [$object => $item->id])"
                        actionType="restore"
                        :id="$item->id"
                        color="primary"
                    >
                    {{ __('Restore') }}
                    </x-general.form-as-button>
                </td>


            </tr>

            <!-- Modal -->

            <x-table.modal :modalId="$item->name.$item->id" :id="$item->id" :name="$item->name" :table="$table" :object="$object" />

            @endforeach
        </tbody>
    </table>

    {{ str_contains(Route::currentRouteAction(), 'index') ? $data->withQueryString()->links() : '' }}

</div>
