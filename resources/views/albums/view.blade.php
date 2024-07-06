@extends($albumsLayout)
@section('title', $title)
@section('content')

    <section class="content container-fluid">
        <h2>{{ $model->title }}</h2>

        <div class="row mb-3">
            <div class="col-12">
                <form action="{{ route('uploader_' . $type . '_delete') }}" method="post">
                    <a class="btn btn-success" href="{{ route('uploader_' . $type . '_edit', ['id' => $model->id]) }}" title="{{ trans('uploader::main.edit') }}">
                        {{ trans('uploader::main.edit') }}
                    </a>
                    <input type="submit" class="btn btn-danger"
                           value="{{ trans('uploader::main.delete') }}"
                           title="{{ trans('uploader::main.delete') }}"
                           onclick="return confirm('{{ trans('uploader::main.sure_confirm') }}')">
                    <input type="hidden" value="{{ $model->id }}" name="items[]">
                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>{{ trans('uploader::main.attribute') }}</th>
                            <th>{{ trans('uploader::main.value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ trans('uploader::main.thumbnail') }}</td>
                            <td>
                                @if(!empty($thumbModel = $model->getThumbnailModel()))
                                    <a href="{{ $thumbModel->getOriginalUrl() }}" target="_blank">
                                        {!! \Itstructure\MFU\Facades\Previewer::getPreviewHtml($thumbModel, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO) !!}
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('uploader::main.title') }}</td>
                            <td>{{ $model->title }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('uploader::main.description') }}</td>
                            <td>{{ $model->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-3">
            @include('uploader::partials.existing-mediafiles', ['mediaFiles' => $mediaFiles ?? []])
        </div>
    </section>

@endsection
