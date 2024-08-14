<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('google_recaptcha_enabled', trans('setting::attributes.google_recaptcha_enabled'), trans('setting::settings.form.enable_google_recaptcha'), $errors, $settings) }}

        <div class="{{ old('google_recaptcha_enabled', array_get($settings, 'google_recaptcha_enabled')) ? '' : 'hide' }}" id="google-recaptcha-fields">
            {{ Form::text('google_recaptcha_site_key', trans('setting::attributes.google_recaptcha_site_key'), $errors, $settings, ['required' => true]) }}
            {{ Form::password('google_recaptcha_secret_key', trans('setting::attributes.google_recaptcha_secret_key'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
