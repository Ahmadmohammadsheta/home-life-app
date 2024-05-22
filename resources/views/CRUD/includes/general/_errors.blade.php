

@error($cloumnName)
<span class="text-danger" role="alert">
    @foreach ($errors->get($cloumnName) as $error)
    <strong>{{ $error }}</strong>
    @endforeach
</span>
@enderror









{{-- @error($cloumnName)
<span class="invalid-feedback" role="alert">    {
    <strong>{{ $message }}</strong>
    @foreach ($errors->get($cloumnName) as $error)
    <strong>{{ $error }}</strong>
    @endforeach
</span>
@enderror --}}



{{-- <div class="alert alert-danger">
    <ul class="">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div> --}}

