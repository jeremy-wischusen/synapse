<?php

class Email {
	public $toEmail;
	public $fromEmail;
	public $subject;
	public $message;
	protected $headers = '';
	public function send() {
		//bool mail  ( string $to  , string $subject  , string $message  [, string $additional_headers  [, string $additional_parameters  ]] )
		$this->addHeader ( 'From: ' . $this->fromEmail );
		return mail ( $this->toEmail, $this->subject, $this->message, $this->headers );
	}
	public function addHeader($str) {
		$this->headers .= $str . "\r\n";
	}
	public function addCC($email) {
		$this->addHeader ( 'Cc: ' . $email );
	}
	public function addBCC($email) {
		$this->addHeader ( 'Bcc: ' . $email );
	}
}

?>