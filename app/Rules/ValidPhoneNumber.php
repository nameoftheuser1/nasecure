<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^(09\d{9}|0\d{2,4}\d{6,7})$/';

        if (!preg_match($pattern, $value)) {
            $fail('The :attribute must be a valid Philippine phone number.');
        }
    }
}
