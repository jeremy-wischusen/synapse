<?php

/*
 * Created by Jeremy Wischusen - Feb 1, 2010.
 */

/**
 * Description of View
 *
 * @author Jeremy Wischusen
 */
class View {
    /**
     * An HTML based view file.
     * @var String
     */
    private $viewFile = null;
    private $data = array();
    protected $styleSheets = array();
    protected $javaScripts = array();
    protected $javaScriptsVars = array();

    public function __construct($fileName) {
        if (empty($fileName)) {
            throw new Exception("File name for view object must not be blank");
        }
        $this->viewFile = $fileName;
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __get($name) {
        return $this->data[$name];
    }

    public function __isset($name) {
        return isset($this->data[$name]);
    }

    public function addData($data) {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $key => $value) {
                $this->__set($key, $value);
            }
        }
    }

    public function display() {
        echo $this->load();
    }

    public function getContents() {
        return $this->load();
    }

    public function __toString() {
        return (string) $this->display();
    }

    public function addStyleSheets(array $sheets) {
        $this->styleSheets = array_merge($this->styleSheets, $sheets);
    }

    public function addJavaScripts(array $scripts) {
        $this->javaScripts = array_merge($this->javaScripts, $scripts);
    }

    public function addJavaScriptsVars(array $vars) {
        $this->javaScriptsVars = array_merge($this->javaScriptsVars, $vars);
    }

    private function load() {
        $file = Site::findFile($this->viewFile, array(
            CURRENT_DIR . '/templates/',
            SITE_ROOT . '/templates/',
        ));
        if ($file=== FALSE) {
            throw new Exception("View $this->viewFile could not be found. Please verify that the path is correct.");
        }
        ob_start();
        try {
            include $file;
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }
        return ob_get_clean();
    }

}

?>
