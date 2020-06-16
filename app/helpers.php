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

if (! function_exists('convertToDash')) {
    function convertToDash($string){ 
        if($string == "" || $string == null){
            return "-";
        }
        return $string;
    }
}

if(!  function_exists("removeFirstCharDash")){
    function removeFirstCharDash($string)
    {
        if($string != null){
            for ($i=0; $i < strlen($string); $i++) { 
                if($string[$i] == "-" || $string[$i] == "=" || $string[$i] == "+"){
                    
                }else{
                    $cleanned = substr($string,$i);
                    if(strtolower($cleanned) == "none"){
                        return "-";
                    }else{
                        return $cleanned;
                    }
                }
            }
            return "-";
        }
        return $string;
    }
}