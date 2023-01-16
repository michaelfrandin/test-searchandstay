<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Isbn implements InvokableRule
{

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $check = 0;

        for ($i = 0; $i < 13; $i += 2) {
            $check += (int)$value[$i];
        }

        for ($i = 1; $i < 12; $i += 2) {
            $check += 3 * $value[$i];
        }

        if (($check % 10) !== 0) {
            $fail(':attribute is invalid, should be valid with ISBN 13.');
        }
    }
}
