<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowedStringName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $attribute;
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
        $this->attribute = $attribute;
        if(trim($value)=="" || $value==null){
            return true;
        }
        return preg_match('/^[\pL\pM_ _-_-]+$/u', $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if(strpos($this->attribute,"embers") > 0){
            return "Invalid characters.";
        }
        return 'The :attribute field has invalid characters.';
    }
}
