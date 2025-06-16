<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BrazilianZipCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{5}-?\d{3}$/', $value)) {
            $fail($this->message());
        }
    }

    public function message(): string
    {
        return 'O CEP informado não está no formato válido (XXXXX-XXX).';
    }
}
