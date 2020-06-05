<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DisallowDash implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $attribute;
    public $value;
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
        $value = trim($value);
        $this->value = $value;
        return $value != "-" && $value != "--";
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // $this->attribute
        if(strpos($this->attribute,"embers") > 0){
            return "Blank if none.";
        }
        if($this->attribute == "pangalan_ng_punong_barangay" || $this->attribute == "pangalan_ng_lswdo"){
            return ':attribute is required.';
        }
        return 'Blank if none.';
    }
}
