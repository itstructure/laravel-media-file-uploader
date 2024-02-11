<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/file-manager.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/uploader/css/upload-manager.css') }}">
    </head>
    <body class="font-sans antialiased">
        <header id="header">
            @if(!empty($referer))
                <a class="btn btn-warning" href="{{ $referer }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                        <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                    </svg>
                    Back
                </a>
            @endif
            <a class="btn @if($manager == 'file_list') btn-outline-secondary disabled @else btn-success @endif" @if($manager == 'file_list') aria-disabled="true" @endif
            href="{{ route('uploader_file_list_manager') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-fill" viewBox="0 0 16 16">
                    <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z"></path>
                </svg>
                File List
            </a>
            <a class="btn @if($manager == 'file_upload') btn-outline-secondary disabled @else btn-success @endif" @if($manager == 'file_upload') aria-disabled="true" @endif
            href="{{ route('uploader_file_upload_manager') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"></path>
                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"></path>
                </svg>
                File Upload
            </a>
        </header>

        <div id="filemanager" role="filemanager" class="file-manager">
            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('vendor/uploader/js/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/uploader/js/main.js') }}"></script>
        <script src="{{ asset('vendor/uploader/js/file-manager.js') }}"></script>
        <script src="{{ asset('vendor/uploader/js/upload-manager.js') }}"></script>
    </body>
</html>
