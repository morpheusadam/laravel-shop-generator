<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('paystack_enabled', trans('setting::attributes.paystack_enabled'), trans('setting::settings.form.enable_paystack'), $errors, $settings) }}
        {{ Form::text('translatable[paystack_label]', trans('setting::attributes.translatable.paystack_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[paystack_description]', trans('setting::attributes.translatable.paystack_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}
        {{ Form::checkbox('paystack_test_mode', trans('setting::attributes.paystack_test_mode'), trans('setting::settings.form.use_sandbox_for_test_payments'), $errors, $settings) }}

        <div class="{{ old('paystack_enabled', array_get($settings, 'paystack_enabled')) ? '' : 'hide' }}" id="paystack-fields">
            {{ Form::text('paystack_public_key', trans('setting::attributes.paystack_public_key'), $errors, $settings, ['required' => true]) }}
            {{ Form::password('paystack_secret_key', trans('setting::attributes.paystack_secret_key'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
