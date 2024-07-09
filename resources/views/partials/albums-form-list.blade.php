<table class="table table-bordered table-sm" width="100%">
    <thead>
    <tr>
        @if(!empty($edition))
            <th width="50">{{ trans('uploader::main.select') }}</th>
        @endif
        <th width="100">{{ trans('uploader::main.thumbnail') }}</th>
        <th>{{ trans('uploader::main.title') }}</th>
        <th>{{ trans('uploader::main.description') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($albums as $album)
        <tr>
            @if(!empty($edition))
                <td>
                    <input type="checkbox" name="{{ $album->type }}[]" value="{{ $album->id }}" title="{{ $album->title }}" @if(!empty($album->relates))checked @endif />
                </td>
            @endif
            <td>
                @php
                    $html = !empty($thumbModel = $album->getThumbnailModel())
                        ? \Itstructure\MFU\Facades\Previewer::getPreviewHtml($thumbModel, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_ITEM)
                        : '';
                @endphp
                @if(!empty($html))
                    <a href="{{ route('uploader_' . $album->type . '_view', ['id' => $album->id]) }}" target="_blank">{!! $html !!}</a>
                @endif
            </td>
            <td>{{ $album->title }}</td>
            <td>{{ $album->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>