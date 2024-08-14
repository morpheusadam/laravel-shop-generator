<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('authorizenet_enabled', trans('setting::attributes.authorizenet_enabled'), trans('setting::settings.form.enable_authorizenet'), $errors, $settings) }}
        {{ Form::text('translatable[authorizenet_label]', trans('setting::attributes.translatable.authorizenet_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[authorizenet_description]', trans('setting::attributes.translatable.authorizenet_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}
        {{ Form::checkbox('authorizenet_test_mode', trans('setting::attributes.authorizenet_test_mode'), trans('setting::settings.form.use_sandbox_for_test_payments'), $errors, $settings) }}

        <div class="{{ old('authorizenet_enabled', array_get($settings, 'authorizenet_enabled')) ? '' : 'hide' }}"
             id="authorizenet-fields">
            {{ Form::text('authorizenet_merchant_login_id', trans('setting::attributes.authorizenet_merchant_login_id'), $errors, $settings, ['required' => true]) }}
            {{ Form::text('authorizenet_merchant_transaction_key', trans('setting::attributes.authorizenet_merchant_transaction_key'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
