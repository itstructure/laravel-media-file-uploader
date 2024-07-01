@extends('uploader::layouts.main')
@section('title', trans('uploader::main.edit'))
@section('content')
    <script type="html/tpl" id="success_delete_feedback">
        @include('uploader::partials.success-delete-feedback', ['text' => trans('uploader::main.deleted_file')])
    </script>
    <div id="file_edit" class="file-edit">

        <div id="edit_pre_loader" class="pre-loader">
            <div class="loader-small"></div>
            <div class="loader-big"></div>
        </div>

        <div class="preview-block">
            <div id="preview_pre_loader" class="pre-loader absolute">
                <div class="loader-small"></div>
                <div class="loader-big"></div>
            </div>
            <div id="file_preview" class="file-preview">
                {!! $preview !!}
            </div>
        </div>

        <div class="edit-form">
            <form id="edit_form" onsubmit="submitEditForm(event)">

                <input type="hidden" name="id" value="{{ $mediaFile->id }}">
                <input type="hidden" name="url" value="{{ $mediaFile->getOriginalUrl() }}">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td>{{ trans('uploader::main.mime') }}</td>
                            <td>{{ $mediaFile->mime_type }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('uploader::main.created') }}</td>
                            <td>{{ $mediaFile->created_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('uploader::main.updated') }}</td>
                            <td>{{ $mediaFile->updated_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('uploader::main.size') }}, kb</td>
                            <td>{{ round($mediaFile->size/1000, 1) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ trans('uploader::main.alt') }}</span>
                    </div>
                    <input type="text" role="alt" name="data[alt]" value="{{ $mediaFile->alt }}" class="form-control" placeholder="{{ trans('uploader::main.alt') }}" aria-label="{{ trans('uploader::main.alt') }}">
                    <div role="validation_alt_feedback" class="invalid-feedback"></div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ trans('uploader::main.title') }}</span>
                    </div>
                    <input type="text" role="title" name="data[title]" value="{{ $mediaFile->title }}" class="form-control" placeholder="{{ trans('uploader::main.title') }}" aria-label="{{ trans('uploader::main.title') }}">
                    <div role="validation_title_feedback" class="invalid-feedback"></div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ trans('uploader::main.description') }}</span>
                    </div>
                    <textarea role="description" name="data[description]" class="form-control" aria-label="Description">{{ $mediaFile->description }}</textarea>
                    <div role="validation_description_feedback" class="invalid-feedback"></div>
                </div>
                <div class="input-group mb-2 file-section">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ trans('uploader::main.file') }}</span>
                    </div>
                    <input type="file" role="file" name="file" class="form-control" placeholder="{{ trans('uploader::main.file') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="clearInput('file')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                            </svg>
                            <span>{{ trans('uploader::main.clear') }}</span>
                        </button>
                    </div>
                    <div role="validation_file_feedback" class="invalid-feedback"></div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        {{ trans('uploader::main.update') }}
                    </button>
                    <button type="button" class="btn btn-info" role="insert-file">
                        {{ trans('uploader::main.insert') }}
                    </button>
                    <button type="button" class="btn btn-danger" onclick="if (window.confirm('{{ trans('uploader::main.delete_confirm') }}')) {deleteFile(event)}">
                        {{ trans('uploader::main.delete') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
