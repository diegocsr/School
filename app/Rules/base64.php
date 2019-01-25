<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class base64 implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value, $parameters, $validator)
    {
        $image = base64_decode(explode(',', $value)[1]);
        $f = finfo_open();
        $mimeType = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
        if (in_array($mimeType, $parameters)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
