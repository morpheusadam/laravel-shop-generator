<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('payfast_enabled', trans('setting::attributes.payfast_enabled'), trans('setting::settings.form.enable_payfast'), $errors, $settings) }}
        {{ Form::text('translatable[payfast_label]', trans('setting::attributes.translatable.payfast_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[payfast_description]', trans('setting::attributes.translatable.payfast_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}
        {{ Form::checkbox('payfast_test_mode', trans('setting::attributes.payfast_test_mode'), trans('setting::settings.form.use_sandbox_for_test_payments'), $errors, $settings) }}

        <div class="{{ old('payfast_enabled', array_get($settings, 'payfast_enabled')) ? '' : 'hide' }}" id="payfast-fields">
            {{ Form::text('payfast_merchant_id', trans('setting::attributes.payfast_merchant_id'), $errors, $settings, ['required' => true]) }}
            {{ Form::text('payfast_merchant_key', trans('setting::attributes.payfast_merchant_key'), $errors, $settings, ['required' => true]) }}
            {{ Form::password('payfast_passphrase', trans('setting::attributes.payfast_passphrase'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
