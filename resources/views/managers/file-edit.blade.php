@extends('uploader::layouts.main')
@section('title', 'File Edit')
@section('content')
    <div class="file-edit">

        <div id="edit_pre_loader" class="pre-loader">
            <div class="loader-small"></div>
            <div class="loader-big"></div>
        </div>

        <div id="file_preview" class="file-preview">
            <div id="preview_pre_loader" class="pre-loader absolute">
                <div class="loader-small"></div>
                <div class="loader-big"></div>
            </div>
            {!! $preview !!}
        </div>
        <div class="file-form">
            <form id="file_form">
                <table class="table table-bordered table-sm">
                    <tbody>
                    <tr>
                        <td>Mime Type</td>
                        <td>{{ $mediaFile->mime_type }}</td>
                    </tr>
                    <tr>
                        <td>Created At</td>
                        <td>{{ $mediaFile->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Updated At</td>
                        <td>{{ $mediaFile->updated_at }}</td>
                    </tr>
                    <tr>
                        <td>File Size, kb</td>
                        <td>{{ round($mediaFile->size/1000, 1) }}</td>
                    </tr>
                    </tbody>
                </table>

                <input type="hidden" name="id" value="{{ $mediaFile->id }}">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon_alt">Alt</span>
                    </div>
                    <input type="text" name="data[alt]" value="{{ $mediaFile->alt }}" class="form-control" placeholder="Alt" aria-label="Alt" aria-describedby="addon_alt">
                    <div id="validation_alt_feedback" class="invalid-feedback"></div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon_title">Title</span>
                    </div>
                    <input type="text" name="data[title]" value="{{ $mediaFile->title }}" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="addon_title">
                    <div id="validation_title_feedback" class="invalid-feedback"></div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Description</span>
                    </div>
                    <textarea name="data[description]" class="form-control" aria-label="Description">{{ $mediaFile->description }}</textarea>
                    <div id="validation_description_feedback" class="invalid-feedback"></div>
                </div>
                <div class="input-group mb-2 file-section">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon_file">New File</span>
                    </div>
                    <input type="file" name="file" class="form-control" placeholder="New file" aria-label="addon_file" role="file-new" multiple="">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">Clear</button>
                    </div>
                    <div id="validation_file_feedback" class="invalid-feedback"></div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-success">Insert</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
@endsection
