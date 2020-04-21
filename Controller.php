<?php
/**
 * User: jeremy
 * Date: Jan 19, 2011
 * Time: 7:09:00 AM
 */

class Controller {

        /**
     * Something went wrong during a procedure in this class that we want to let the user know about.
     * @var Array
     */
    public $errors = array();
    /**
     * General messages to display to the user not related to errors.
     * @var Array
     */
    public $messages = array();
    /**
     *
     * @var Session
     */
    public $session;
    /**
     *
     * @var Post
     */
    public $post;
    /**
     *
     * @var Get
     */
    public $get;

    protected function  __construct() {
        $this->session = Session::getInstance();
        $this->post = Post::getInstance();
        $this->get = Get::getInstance();
    }
}
