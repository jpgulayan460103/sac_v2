<?php


if (! function_exists('getAge')) {
    function getAge($dob, $condate){ 
        $birthdate = new \DateTime(date("m/d/Y",  strtotime($dob)));
        $today= new \DateTime(date("m/d/Y",  strtotime($condate)));           
        $age = $birthdate->diff($today)->format('%R%a');
        if((integer)$age < 0){
            return -1;
        }else{
            $age = $birthdate->diff($today)->y;
        }
        return $age;
    }
}