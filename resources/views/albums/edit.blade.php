@extends($albumsLayout)
@section('title', $title)
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12 pt-2 pb-4">

                <h2>{{ $model->title }} | <a href="{{route('uploader_' . $type . '_view', ['id' => $model->id])}}">{{ trans('uploader::main.view') }} >></a></h2>

                <form action="{{ route('uploader_' . $type . '_update', ['id' => $model->id]) }}" method="post">

                    @include('uploader::albums._fields', ['ownerParams' => ['ownerName' => $type, 'ownerId' => $model->id]])

                    <button class="btn btn-primary" type="submit">{{ trans('uploader::main.update') }}</button>

                </form>

            </div>
        </div>
    </section>

@stop
