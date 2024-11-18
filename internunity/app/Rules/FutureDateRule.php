<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FutureDateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __construct(
        protected $from
    ) {}
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$value) return;
        if(strtotime($value) < strtotime($this->from)) {
            $fail("The ':attribute' date must not be earlier than the 'from' date.");
        }
    }
}
