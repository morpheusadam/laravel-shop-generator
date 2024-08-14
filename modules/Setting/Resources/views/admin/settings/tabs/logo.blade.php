@include('media::admin.image_picker.single', [
    'title' => trans('setting::settings.form.logo'),
    'inputName' => 'translatable[admin_logo]',
    'file' => $logo,
])

<div class="media-picker-divider"></div>

@include('media::admin.image_picker.single', [
    'title' => trans('setting::settings.form.small_logo'),
    'inputName' => 'translatable[admin_small_logo]',
    'file' => $shortLogo,
])
