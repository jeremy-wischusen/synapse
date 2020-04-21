<?php

class StringFormatter {
    
    public static function phoneNumberWithSeprators($number, $seperator = '-') {
        $number = self::phoneNumberDigitsOnly($number);
        $formatted = substr($number, 0, 3) . $seperator . substr($number, 3, 3) . $seperator . substr($number, 6);
        return $formatted;
    }
    
    public static function phoneNumberDigitsOnly($number) {
        return substr(self::digitsOnly(ltrim($number,'1')), 0,10);
    }
    
    public static function digitsOnly($str) {
        return preg_replace('/[^0-9]+/', '', $str);
    }
}

?>