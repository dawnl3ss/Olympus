<?php

class Utils {
    
    /**
     * @param array $arr
     */
    public static function array_to_string(array $arr){
        $string_array = "";
        $assoc_index = 0;

        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $string_array .= "{$assoc_index} => {" . "<br>";
                $assoc_index++;

                foreach ($value as $key1 => $value1) {
                    if (is_array($value1)) {} else {
                        $string_array .= "    {$key1} => {$value1}," . "<br>";
                    }
                }
            } else {
                $string_array .= "{$key} => {$value}," . "<br>";
            }
        }
        return $string_array;
    }
}