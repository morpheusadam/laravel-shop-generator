<!DOCTYPE html>
<html lang="{{ locale() }}">
<head>
    <meta charset="UTF-8">

    <title>{{ trans('media::media.file_manager.title') }}</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:600|Roboto" rel="stylesheet">

    <script src="{{ v(asset('build/assets/jquery.min.js')) }}"></script>

    @vite([
        'modules/Admin/Resources/assets/sass/main.scss',
        'modules/Admin/Resources/assets/js/main.js',
        'modules/Admin/Resources/assets/js/app.js',
        'modules/Media/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/js/main.js'
    ])

    @include('admin::partials.globals')
</head>

<body class="file-manager {{ is_rtl() ? 'rtl' : 'ltr' }}">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        @include('media::admin.media.partials.uploader')
                        @include('media::admin.media.partials.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="notification-toast"></div>

    @include('admin::partials.confirmation_modal')

    <script type="module">
        DataTable.setRoutes('.file-manager .table', {
            table: {
                name: 'admin.media.table',
                params: { type: '{{ $type }}' }
            },
            destroy: 'admin.media.destroy',
        });

        new DataTable('.file-manager .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'id', width: '5%' },
                { data: 'thumbnail', orderable: false, searchable: false, width: '10%' },
                { data: 'filename', name: 'filename' },
                { data: 'created', name: 'created_at' },
                { data: 'action', orderable: false, searchable: false },
            ],
        });
    </script>
</body>
</html>
