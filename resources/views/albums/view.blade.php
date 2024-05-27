@extends($albumsLayout)
@section('title', $title)
@section('content')

    <section class="content container-fluid">
        <h2>{{ $model->title }}</h2>

        <div class="row mb-3">
            <div class="col-12">
                <form action="{{ route('uploader_' . $type . '_delete') }}" method="post">
                    <a class="btn btn-success" href="{{ route('uploader_' . $type . '_edit', ['id' => $model->id]) }}" title="Edit">Edit</a>
                    <input type="submit" class="btn btn-danger" value="Delete" title="Delete" onclick="return confirm('Are you sure?')">
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
                            <th>Attribute</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Thumbnail</td>
                            <td>
                                @if(!empty($thumbModel = $model->getThumbnailModel()))
                                    {!! \Itstructure\MFU\Facades\Previewer::getPreviewHtml($thumbModel, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO) !!}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td>{{ $model->title }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{{ $model->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
