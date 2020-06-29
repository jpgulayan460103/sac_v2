<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidExtName implements Rule
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
    public function passes($attribute, $value)
    {
        if($value == "" || $value == null){
            return true;
        }else{
            return (strlen($value) <= 3);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The ext name must not exceed 3 characters.';
    }
}
