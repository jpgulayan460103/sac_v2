<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCellphoneNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $error_type;
    public function __construct()
    {
        
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
        if($value != "-" && strlen($value) != 11){
            $this->error_type = "char";
            return false;
        }
        if($value != "-" && substr($value, 0, 2) != "09"){
            $this->error_type = "start";
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->error_type == "char"){
            return 'The cellphone number must be 11 characters.';
        }else{
            return "The cellphone number must start with 09";
        }
    }
}
