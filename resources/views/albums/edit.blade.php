@extends($albumsLayout)
@section('title', $title)
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12 pt-2 pb-4">

                <h2>{{ $model->title }}</h2>

                <div class="row mb-3">
                    <div class="col-12">
                        <a class="btn btn-warning" href="{{ url()->previous() }}" title="{{ trans('uploader::main.back') }}">
                            << {{ trans('uploader::main.back') }}
                        </a>
                        <a class="btn btn-primary" href="{{ route('uploader_' . $type . '_view', ['id' => $model->id]) }}" title="{{ trans('uploader::main.view') }}">
                            {{ trans('uploader::main.view') }}
                        </a>
                    </div>
                </div>

                <form action="{{ route('uploader_' . $type . '_update', ['id' => $model->id]) }}" method="post">

                    @include('uploader::albums._fields', ['edition' => true, 'ownerParams' => ['ownerName' => $type, 'ownerId' => $model->id]])

                    <button class="btn btn-primary" type="submit">{{ trans('uploader::main.update') }}</button>

                </form>

            </div>
        </div>
    </section>

@stop
