

@foreach ($columsWithDataTypes as $column)

    @php
        $modelObjectNameValue = $column['name'];
    @endphp

    <label style="text-align: center important; display: inline-block" class="text-primary">{{ __(ucfirst($column['name'])) }}</label>

    @if ($column['type'] == "bigint") {{-- for relation model --}}

        @include('crud._selectInput')

    @elseif ($column['type'] == "varchar" && $column['name'] !== "image") {{-- the normal inputs --}}

        @include('crud._stringInput')

    @elseif ($column['name'] == "image")

        @include('crud._imgInput')

    @elseIf ($column['name'] == "is_parent") {{-- radio input --}}

        @include('crud._radioInput')

    @endif

@endforeach
