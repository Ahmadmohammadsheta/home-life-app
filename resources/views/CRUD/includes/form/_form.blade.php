

@foreach ($columsWithDataTypes as $column)

    @php
        $modelObjectNameValue = $column['name'];
    @endphp

    <label style="text-align: center important; display: inline-block" class="text-primary">{{ __(ucfirst($column['name'])) }}</label>

    @if ($column['type'] == "bigint") <!-- for relation model -->

        @include('crud.includes.form._selectInput2')

    @elseif ($column['type'] == "varchar" && $column['name'] !== "image") <!-- the normal inputs -->

        @include('crud.includes.form._stringInput')

    @elseif ($column['name'] == "image")

        @include('crud.includes.form._imgInput')

    @elseIf ($column['name'] == "is_parent") <!-- radio input -->

        @include('crud.includes.form._radioInput')

    @endif

@endforeach

<div class="d-flex justify-content-center">
    <button type="submit" class="btn btn-success d-block w-100">{{ $action }}</button>
</div>
