<?php

namespace OmniaDigital\CatalystCore\Rules\Jobs;

use Illuminate\Contracts\Validation\Rule;
use OmniaDigital\CatalystCore\Models\Tag;

class ValidTags implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! is_array($value)) {
            return false;
        }

        return Tag::whereIn('id', $value)->count() === count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please only select tag on the list.';
    }
}
