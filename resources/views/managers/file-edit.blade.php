@extends('uploader::layouts.main')
@section('title', 'File Edit')
@section('content')
    <div class="file-edit">
        <div class="file-preview">
            {!! $preview !!}
        </div>
        <div class="file-form">
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
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon_alt">Alt</span>
                </div>
                <input type="text" class="form-control" placeholder="Alt" aria-label="Alt" aria-describedby="addon_alt">
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon_title">Title</span>
                </div>
                <input type="text" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="addon_title">
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text">Description</span>
                </div>
                <textarea class="form-control" aria-label="Description"></textarea>
            </div>
            <div class="input-group mb-2 file-section">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon_file">New File</span>
                </div>
                <input type="file" class="form-control" placeholder="New file" aria-label="addon_file" name="file" role="file-new" multiple="">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">Clear</button>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-success">Insert</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
@endsection
