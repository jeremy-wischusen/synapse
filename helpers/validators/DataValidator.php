<?php

/**
 * class DataValidator
 *
 */
class DataValidator {

    /**
     *
     *
     * @return
     * @access public
     */
    public function __construct( ) {

    }

    // end of member function __construct
    /**
     *
     *
     * @param string str String to be checked for blank condition.

     * @return bool
     * @access public
     */
    public function notBlank($str) {
        $str = trim($str);
        return !empty($str);
    }

    // end of member function notBlank
    /**
     *
     *
     * @param string email String to check for proper email formatting.

     * @return bool
     * @access public
     */
    public function isEmail($email) {
        $email = trim($email);
        return preg_match('/.+@.+\.[a-z A-Z]{2,4}$/i', $email);
    }

    // end of member function isEmail
    /**
     *
     *
     * @param string keyOne First match value.

     * @param string keyTwo Second match value.

     * @return bool
     * @access public
     */
    public function match($keyOne, $keyTwo) {
        return trim($keyOne) == trim($keyTwo);
    }
    // end of member function match
}

// end of DataValidator
?>
