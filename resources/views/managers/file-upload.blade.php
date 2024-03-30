@extends('uploader::layouts.main')
@section('title', 'File Upload')
@section('content')
    <script type="html/tpl" id="upload_block">
        @include('uploader::partials.upload-block')
    </script>
    <div id="file_upload" class="file-upload">
        @include('uploader::partials.upload-block')
    </div>
@endsection
