@extends($albumsLayout)
@section('title', $title)
@section('content')

    <section class="content container-fluid">
        <div class="row">
            <div class="col-12">

                <h1>{{ $title }}</h1>

                <form action="{{ route('uploader_' . $type . '_store') }}" method="post">

                    @include('uploader::albums._fields')

                    <button class="btn btn-primary" type="submit">Create</button>

                </form>

            </div>
        </div>
    </section>

@stop
