<?php
/**
 * class BatchValidator
 *
 */
class BatchValidator {
    /*** Attributes: ***/
    /**
     *
     * @access public
     * @var DataValidator $validator
     */
    public $validator;
    /**
     *
     * @access private
     * @var array $errors
     */
    private $errors = array();
    /**
     *
     * @access private
     * @var array
     */
    private $invalid = array();
    /**
     *
     * @access private
     * @var array
     */
    private $data = null;
    /**
     *@access private;
     * @var array
     */
    private $labels = null;
    /**
     * @access private;
     * @var array
     */
    private $operations = array();
    /**
     *
     *
     * @param array data An array containing the data to be validated (e.g, $_POST).
     * @param array labels Contains user friendly labels for validation error messages. For example, if
     there is a array key firstName in the data array, the labels array could contain
     an entry firstName=>'First name'.
     * @access public
     */
    public function __construct( $data,  $labels ) {
        $this->validator = new DataValidator();
        $this->data = $data;
        $this->labels = $labels;
    } // end of member function __construct

    /**
     * Performs the validation operations for the keys that have been set by one of the
     * funcitons that specifies the keys to be checked. If no keys have been set, it
     * will return -1 since no validation has actually been performed.
     *
     * @return bool
     * @access public
     */
    public function validate( ) {
        //no data array or no operations to perform return -1.
        if (empty ($this->data) || empty ($this->operations)) {
            return -1;
        }
        foreach ($this->operations['notBlank'] as $key) {
            if(!$this->validator->notBlank($this->data[$key])) {
                $this->addError(" cannot be blank.", $key);
            }

        }
        foreach ($this->operations['isEmail'] as $key) {
            if(!$this->validator->isEmail($this->data[$key])) {
                $this->addError(" is not a valid email.", $key);
            }

        }
        foreach ($this->operations['match'] as $key) {
            $parts = explode(':', $key);
            if(!$this->validator->match($this->data[$parts[0]], $this->data[$parts[1]])) {
                $this->addError("s do not match.", $parts[0]);
                $this->addInvalid($parts[1]);
            }

        }
        return empty ($this->errors);
    } // end of member function validate
    private function addError($msg, $key) {
        $label = empty($this->labels[$key])?$key:$this->labels[$key];
        $this->errors[]=$label.$msg;
        $this->addInvalid($key);
    }
    private function addInvalid($key) {
        if(!in_array($key, $this->invalid)) {
            $this->invalid[]=$key;
        }
    }
    /**
     *
     *
     * @return array
     * @access public
     */
    public function getErrors( ) {
        return $this->errors;
    } // end of member function getErrors

    /**
     *
     *
     * @return array
     * @access public
     */
    public function getInvalid( ) {
        return $this->invalid;
    } // end of member function getInvalid

    /**
     *
     *
     * @param array keys Contains the keys in data array that should be check for non-blank values.

     * @return
     * @access public
     */
    public function notBlank( $keys ) {
        $this->operations['notBlank'] = $keys;
    } // end of member function notBlank

    /**
     *
     *
     * @param array keys Contains the keys in the data array that should be checked for a valid email
     pattern.

     * @return
     * @access public
     */
    public function isEmail( $keys ) {
        $this->operations['isEmail'] = $keys;
    } // end of member function isEmail

    /**
     *
     *
     * @param array keys Contains the keys in the data array that should be compared for matching values.
     This array must contain entries seperated by colons for matching pair. For
     example "email:confirmemail".

     * @return
     * @access public
     */
    public function match( $keys ) {
        $this->operations['match'] = $keys;
    } // end of member function match

} // end of BatchValidator
?>