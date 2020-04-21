<?php

/**
 * Helper class for working with the $_POST global array.
 *
 * @author Jeremy Wischusen
 */
class Post {

    /**
     *
     * @var Post
     */
    private static $instance = null;

    private function __construct() {

    }

    public function isEmpty() {
        return empty($_POST);
    }

    public function __isset($name) {
        return isset($_POST[$name]);
    }

    public function __set($name, $value) {
        $_POST[$name] = $value;
    }

    public function __get($name) {
        return $_POST[$name];
    }

    public function bulkSet($data) {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    public function delete($key) {
        unset($_POST[$key]);
    }

    public function bulkDelete($keys) {
        foreach ($keys as $key) {
            unset($_POST[$key]);
        }
    }

    public function toArray() {
        return $_POST;
    }

    /**
     *
     * @return Post;
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Post();
        }
        return self::$instance;
    }

}
?>
