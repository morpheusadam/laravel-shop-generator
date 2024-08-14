<button
    type="button"
    class="btn btn-default select-media"
    data-id="{{ $file->id }}"
    data-path="{{ $file->path }}"
    data-filename="{{ $file->filename }}"
    data-type="{{ strtok($file->mime, '/') }}"
    data-icon="{{ $file->icon() }}"
>
    {{ trans('media::media.file_manager.insert') }}
</button>
