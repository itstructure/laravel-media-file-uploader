<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
        @include('uploader::partials.thumbnail', ['model' => $model ?? null])
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
        <div class="form-group">
            <label for="album_title">Title</label>
            <input id="album_title" type="text" class="form-control @if ($errors->has('title')) is-invalid @endif"
                   name="title" value="{{ old('title', isset($model) ? $model->title : null) }}" required autofocus>
            @if ($errors->has('title'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('title') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
        <div class="form-group">
            <label for="album_description">Description</label>
            <textarea id="album_description" type="text" class="form-control @if ($errors->has('description')) is-invalid @endif"
                      name="description" required autofocus>{{ old('description', !empty($model) ? $model->description : null) }}</textarea>
            @if ($errors->has('description'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<input type="hidden" value="{{ $type }}" name="type">

<input type="hidden" value="{!! csrf_token() !!}" name="_token">