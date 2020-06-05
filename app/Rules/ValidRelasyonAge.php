<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRelasyonAge implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $index;
    public $value;
    public function __construct($index)
    {
        $this->index = $index;
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
        $this->value = $value;
        $members = request('members');
        if(!isset($members[$this->index]['kapanganakan'])){
            $this->value = "no_dob";
            return false;
        }
        $member_dob = $members[$this->index]['kapanganakan'];
        $head_dob = request('kapanganakan');
        $base_date = date('m/d/Y');

        $head_age = getAge($head_dob, $base_date);
        $member_age = getAge($member_dob, $base_date);
        $age_difference = $head_age - $member_age;
        switch ($value) {
            case "3 - Anak":
                return $age_difference >= 8; 
                break;
            case "6 - Apo":
                return $age_difference >= 16; 
                break;
            case "7 - Ama / Ina":
                $age_difference = $member_age - $head_age;
                return $age_difference >= 8; 
                break;
            default:
                
                break;
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
        switch ($this->value) {
            case '3 - Anak':
                return "Must be 8 years younger to the punong pamilya";
                break;
            case '6 - Apo':
                return "Must be 16 years younger to the punong pamilya";
                break;
            case '7 - Ama / Ina':
                return "Must be 8 years older to the punong pamilya";
                break;
            case 'no_dob':
                return "Kapanganakan is required";
                break;
            
            default:
                # code...
                break;
        }
        return 'The validation error message.';
    }
}
