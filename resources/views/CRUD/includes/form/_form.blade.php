

@foreach ($columsWithDataTypes as $column)

    @php
        $cloumnName = $column['name'];
    @endphp

        <x-form.label :id="$cloumnName">{{ Str::ucfirst($cloumnName) }}</x-form.label>

    @if ($column['type'] == "bigint") <!-- for relation model -->

        <x-form.select :arrayForSelectInput="$arrayForSelectInput" :name="$cloumnName" :selected="old($cloumnName, $$modelObjectName->$cloumnName)" />

    @elseif ($column['type'] == "varchar" && $cloumnName !== "image") <!-- the normal inputs -->

        <x-form.input class="p-1" type="text" :name="$cloumnName" :value="old($cloumnName, $$modelObjectName->$cloumnName)" required='required' />

    @elseif ($cloumnName == "image")

    <x-form.input type="file" :name="$cloumnName" :object="$$modelObjectName" :value="old($cloumnName, $$modelObjectName->$cloumnName)" accept="image/*" />

    @elseIf ($cloumnName == "is_parent") <!-- radio input -->

    <x-form.radio :name="$cloumnName" :checked="$$modelObjectName->$cloumnName" :options="['1' => 'True']" />

    @endif

@endforeach

<div class="d-flex justify-content-center">
    <button type="submit" class="btn btn-primary d-block w-100">{{ $action }}</button>
</div>
