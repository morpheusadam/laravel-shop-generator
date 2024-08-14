@push('globals')
    <script>
        FleetCart.maxFileSize = {{ (int) ini_get('upload_max_filesize') }}
    </script>
@endpush

<form method="POST" class="dropzone">
    {{ csrf_field() }}

    <div class="dz-message needsclick">
        {{ trans('media::media.drop_files_here') }}
    </div>
</form>
