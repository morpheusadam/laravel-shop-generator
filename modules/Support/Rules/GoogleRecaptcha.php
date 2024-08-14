<?php

namespace Modules\Support\Rules;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Validation\ValidationRule;

class GoogleRecaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::get("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => setting('google_recaptcha_secret_key'),
            'response' => $value,
        ]);

        if (!($response->json()["success"] ?? false)) {
            $fail(trans('support::recaptcha.validation.failed_to_verify'));
        }
    }
}
