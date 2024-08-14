<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('pwa_enabled', trans('setting::attributes.pwa_enabled'), trans('setting::settings.form.enable_pwa'), $errors, $settings) }}
        
        <div class="media-picker-divider"></div>

        @include('media::admin.image_picker.single', [
            'title' => trans('setting::settings.form.pwa_icon'),
            'inputName' => 'pwa_icon',
            'file' => $icon,
        ])

        <div class="media-picker-divider"></div>
        
        {{ Form::color('pwa_theme_color', trans('setting::attributes.pwa_theme_color'), $errors, $settings) }}
        {{ Form::color('pwa_background_color', trans('setting::attributes.pwa_background_color'), $errors, $settings) }}
        {{ Form::color('pwa_status_bar', trans('setting::attributes.pwa_status_bar'), $errors, $settings) }}
        {{ Form::select('pwa_display', trans('setting::attributes.pwa_display'), $errors, $displays, $settings) }}
        {{ Form::select('pwa_orientation', trans('setting::attributes.pwa_orientation'), $errors, $orientations, $settings) }}
        {{ Form::select('translatable[pwa_direction]', trans('setting::attributes.pwa_direction'), $errors, $directions, $settings) }}
    </div>
</div>
