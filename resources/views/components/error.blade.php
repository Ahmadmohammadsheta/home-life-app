



@error( $name )
<span class="text-danger" role="alert">
    @foreach ($errors->get( $name ) as $error)
    <strong>{{ $error }}</strong>
    @endforeach
</span>
@enderror
