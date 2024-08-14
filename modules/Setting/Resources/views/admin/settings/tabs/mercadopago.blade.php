<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('mercadopago_enabled', trans('setting::attributes.mercadopago_enabled'), trans('setting::settings.form.enable_mercadopago'), $errors, $settings) }}
        {{ Form::text('translatable[mercadopago_label]', trans('setting::attributes.translatable.mercadopago_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[mercadopago_description]', trans('setting::attributes.translatable.mercadopago_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}
        {{ Form::checkbox('mercadopago_test_mode', trans('setting::attributes.mercadopago_test_mode'), trans('setting::settings.form.use_sandbox_for_test_payments'), $errors, $settings) }}

        <div class="{{ old('mercadopago_enabled', array_get($settings, 'mercadopago_enabled')) ? '' : 'hide' }}"
             id="mercadopago-fields">
            {{ Form::select('mercadopago_supported_currency', trans('setting::attributes.supported_currency'), $errors, $currencies, $settings, ['required' => true]) }}
            {{ Form::text('mercadopago_public_key', trans('setting::attributes.mercadopago_public_key'), $errors, $settings, ['required' => true]) }}
            {{ Form::password('mercadopago_access_token', trans('setting::attributes.mercadopago_access_token'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
