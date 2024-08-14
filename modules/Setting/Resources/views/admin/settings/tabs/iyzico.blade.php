<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('iyzico_enabled', trans('setting::attributes.iyzico_enabled'), trans('setting::settings.form.enable_iyzico'), $errors, $settings) }}
        {{ Form::text('translatable[iyzico_label]', trans('setting::attributes.iyzico_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[iyzico_description]', trans('setting::attributes.iyzico_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}
        {{ Form::checkbox('iyzico_test_mode', trans('setting::attributes.iyzico_test_mode'), trans('setting::settings.form.use_sandbox_for_test_payments'), $errors, $settings) }}

        <div class="{{ old('iyzico_enabled', array_get($settings, 'iyzico_enabled')) ? '' : 'hide' }}" id="iyzico-fields">
            {{ Form::select('iyzico_supported_currencies', trans('setting::attributes.supported_currencies'), $errors, $currencies, $settings, ['class' => 'selectize prevent-creation', 'required' => true, 'multiple' => true]) }}
            {{ Form::text('iyzico_api_key', trans('setting::attributes.iyzico_api_key'), $errors, $settings, ['required' => true]) }}
            {{ Form::password('iyzico_api_secret', trans('setting::attributes.iyzico_api_secret'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
