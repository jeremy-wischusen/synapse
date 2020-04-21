<?php
class HTMLEmail extends Email {
    public function __construct() {
        $this->addHeader('Content-type: text/html; charset=iso-8859-1');
    }
}

?>