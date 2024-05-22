



{{-- @error( $name )
<span class="text-danger" role="alert">
    @foreach ($errors->get( $name ) as $error)
    <strong>{{ $error }}</strong><br>
    @endforeach
</span>
@enderror --}}




@error($name)
<span class="invalid-feedback" role="alert">
    @foreach ($errors->get($name) as $error)
    <strong>{{ $error }}</strong> <br>
    @endforeach
</span>
@enderror



{{-- <div class="alert alert-danger">
    <ul class="">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li><br>
        @endforeach
    </ul>
</div> --}}
