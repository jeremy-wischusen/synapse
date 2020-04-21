<?php
abstract class Command extends Controller {

    protected function  __construct() {
        $this->execute();
    }

    abstract protected function execute();

    public function success() {
        return empty($this->errors) ? true : $this->errors;
    }

}

?>