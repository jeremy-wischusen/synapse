<?php

/**
 * Helper class for working with the $_SESSION global array.
 *
 * @author Jeremy Wischusen
 */
class Session {

    /**
     *
     * @var Session;
     */
    private static $instance = null;

    private $tokens = array();

    private function __construct() {
        @session_start();
    }

    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function bulkSet($data) {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    public function __get($key) {
        return $_SESSION[$key];
    }

    public function delete($key) {
        unset($_SESSION[$key]);
    }

    public function bulkDelete($keys) {
        foreach ($keys as $key) {
            unset($_SESSION[$key]);
        }
    }

    public function isEmpty() {
        return empty($_SESSION);
    }

    public function __isset($name) {
        return isset($_SESSION[$name]);
    }

    public function toArray() {
        return $_SESSION;
    }

    public function close() {
        session_write_close();
    }

    public function destroy() {
        @session_destroy();
    }
    public function createToken($key='token'){
        $key = empty($key)?'token':$key;
        $this->tokens[$key] = uniqid();
        return $this->tokens[$key];
    }

    /**
     *
     * @return Session;
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

}
?>
