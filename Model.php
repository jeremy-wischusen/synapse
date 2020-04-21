<?php

abstract class Model {

    protected $data = array();

    public function __isset($name) {
        return isset($data[$name]);
    }

    public function __set($name, $value) {
        $data[$name] = $value;
    }

    public function __get($name) {
        return $data[$name];
    }

    public function __unset($name) {
        unset($data[$name]);
    }

}

?>
