<?php

class ServiceResult {

    /**
     *
     * @var Boolean
     */
    public $success;
    /**
     *
     * @var Array 
     */
    public $errors;
    /**
     *
     * @var Array
     */
    public $messages;
    /**
     * Holds data returned by a service or passthrough data.
     */
    public $data;
    /**
     *
     * @var String - Holds an event name that can be triggered in javascript when the service call is successful.
     */
    public $onSuccessEvent;
    /**
     *
     * @var String - Holds an event name that can be triggered in javascript when the service call fails.
     */
    public $onErrorEvent;
}
?>
