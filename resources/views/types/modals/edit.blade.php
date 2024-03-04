
    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sections.updating') }}" method="post" autocomplete="off">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('اسم القسم') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="id" name="id">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">{{ __('ملاحظات') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"  name="description" rows="3" value="{{ old('description') }}" autocomplete="description" autofocus></textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ __('تاكيد') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('اغلاق') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
