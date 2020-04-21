<?php

/**
 * Helper class for working with the $_POST global array.
 *
 * @author Jeremy Wischusen
 */
class Get {

    /**
     *
     * @var Get
     */
    private static $instance = null;

    private function __construct() {

    }

    public function isEmpty() {
        return empty($_GET);
    }

    public function __isset($name) {
        return isset($_GET[$name]);
    }

    public function __set($name, $value) {
        $_GET[$name] = $value;
    }

    public function __get($name) {
        return $_GET[$name];
    }

    public function bulkSet($data) {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    public function delete($key) {
        unset($_GET[$key]);
    }

    public function bulkDelete($keys) {
        foreach ($keys as $key) {
            unset($_GET[$key]);
        }
    }

    public function toArray() {
        return $_GET;
    }

    /**
     *
     * @return Post;
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Get();
        }
        return self::$instance;
    }

}
?>
