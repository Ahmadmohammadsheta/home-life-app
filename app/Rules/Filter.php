<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{
    /**
     * AMA custom prpoerties
     */
    protected $forbidden;

    /**
     * AMA custom __constrution
     */
    public function __construct(array $forbidden) {
        $this->forbidden = $forbidden;
    }
    public function forbiddens($value) {
        foreach ($this->forbidden as $forbidden) {
            return str_contains(strtolower($value), $forbidden) ? false : true;
        }
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->forbiddens($value) ?: $fail($attribute, 'This name is not allowed');
        // !(in_array(strtolower($value), $this->forbidden)) ?: $fail($attribute, 'This name is not allowed');
    }
}
