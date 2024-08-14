<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('flutterwave_enabled', trans('setting::attributes.flutterwave_enabled'), trans('setting::settings.form.enable_flutterwave'), $errors, $settings) }}
        {{ Form::text('translatable[flutterwave_label]', trans('setting::attributes.translatable.flutterwave_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[flutterwave_description]', trans('setting::attributes.translatable.flutterwave_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}
        {{ Form::checkbox('flutterwave_test_mode', trans('setting::attributes.flutterwave_test_mode'), trans('setting::settings.form.use_sandbox_for_test_payments'), $errors, $settings) }}

        <div class="{{ old('flutterwave_enabled', array_get($settings, 'flutterwave_enabled')) ? '' : 'hide' }}" id="flutterwave-fields">
            {{ Form::text('flutterwave_public_key', trans('setting::attributes.flutterwave_public_key'), $errors, $settings, ['required' => true]) }}
            {{ Form::password('flutterwave_secret_key', trans('setting::attributes.flutterwave_secret_key'), $errors, $settings, ['required' => true]) }}
            {{ Form::password('flutterwave_encryption_key', trans('setting::attributes.flutterwave_encryption_key'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
