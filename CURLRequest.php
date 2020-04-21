<?php

/*
 * Created by Jeremy Wischusen - Apr 30, 2010.
 */

/**
 * Description of CURLRequest
 *
 * @author jeremy
 */
class CURLRequest {

//undo this
    public $curl;
    private $url;

    public function __construct($url = NULL, $options= NULL) {
        $this->url = $url;
        $this->init();
        if (is_array($options)) {
            foreach ($options as $opt => $value) {
                curl_setopt($this->curl, $opt, $value);
            }
        }
    }

    public function execute() {
        return curl_exec($this->curl);
    }

    public function setPostData($data) {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($this->curl, CURLOPT_POST, 1);
    }

    public function setUrl($url) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
    }

    private function init() {
        $this->curl = curl_init($this->url);
    }

    public function __destruct() {
        curl_close($this->curl);
    }

}
?>
