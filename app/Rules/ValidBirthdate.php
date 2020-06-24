<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidBirthdate implements Rule
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
        if($this->custom_valid_date($value)){
            return (getAge($value, date('m/d/Y')) >= 0);
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
        return 'Must not contain a future date.';
    }

    public function custom_valid_date(string $value = null)
    {
        $value = trim($value);
        $date = explode('/', $value);
        if(!isset($date[0])){
            return false;
        }
        if(!isset($date[1])){
            return false;
        }
        if(!isset($date[2])){
            return false;
        }
        return checkdate($date[0],$date[1],$date[2]);
    }
}
