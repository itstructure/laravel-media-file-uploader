<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4 mb-3">
        @include('uploader::partials.thumbnail', ['model' => $model ?? null, 'ownerParams' => $ownerParams ?? null])
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-10 col-md-8 col-lg-12 col-xl-8">
        <div class="form-group">
            <label for="album_title">{{ trans('uploader::main.title') }}</label>
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
    <div class="col-12 col-sm-10 col-md-8 col-lg-12 col-xl-8">
        <div class="form-group">
            <label for="album_description">{{ trans('uploader::main.description') }}</label>
            <textarea id="album_description" type="text" class="form-control @if ($errors->has('description')) is-invalid @endif" rows="3"
                      name="description" required autofocus>{{ old('description', !empty($model) ? $model->description : null) }}</textarea>
            @if ($errors->has('description'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<hr />
<h5>{{ trans('uploader::main.new_files') }}</h5>
<div class="row mb-3">
    @include('uploader::partials.new-mediafiles', ['fileType' => \Itstructure\MFU\Models\Albums\AlbumTyped::getFileType($type), 'ownerParams' => $ownerParams ?? null])
</div>

@if(!empty($edition))
    <hr />
    <h5>{{ trans('uploader::main.existing_files') }}</h5>
    <div class="row mb-3">
        @include('uploader::partials.existing-mediafiles', [
            'edition' => true,
            'fileType' => \Itstructure\MFU\Models\Albums\AlbumTyped::getFileType($type),
            'ownerParams' => $ownerParams ?? null,
            'mediaFiles' => $mediaFiles ?? []]
        )
    </div>
@endif

<hr />

<input type="hidden" value="{{ $type }}" name="type">

<input type="hidden" value="{!! csrf_token() !!}" name="_token">