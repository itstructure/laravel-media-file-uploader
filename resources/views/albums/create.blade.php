@extends($albumsLayout)
@section('title', $title)
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12 pt-2 pb-4">

                <h1>{{ $title }}</h1>

                <form action="{{ route('uploader_' . $type . '_store') }}" method="post">

                    @include('uploader::albums._fields')

                    <button class="btn btn-primary" type="submit">{{ trans('uploader::main.create') }}</button>

                </form>

            </div>
        </div>
    </section>

@stop
