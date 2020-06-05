<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequiredIfNotEmpty implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $field;
    public function __construct($field)
    {
        $this->field = $field;
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
        $value = trim(strtolower($value));
        $data = trim(strtolower(request($this->field)));
        if($data != "" && $data != "-" && $data !="n"){
            return ($value != "" && $value != "-" && $value !="n");
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is required if '.$this->field.' is stated.';
    }
}
