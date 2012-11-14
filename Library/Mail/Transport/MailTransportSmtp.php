<?php

/**
 * Die Klasse MailTransportSendmail versendet Mail über einen bestehendes SMTP Konto.
 * Die Verbindung zum SMTP Server wird per Sockets hergestellt.
 *
 * @package		Mail
 * @category	Mail
 * @subpackage	MailTransporters
 * @copyright	Copyright (c) 2006 Claudio Walser
 * @author		Claudio Walser
 */
class MailTransportSmtp extends MailTransport {

	const TIMEOUT			= 30;
	const PORT				= 25;

	private $_server 		= null;
	private $_user 			= null;
	private $_pass 			= null;
	private $_port			= null;
	private $_timeout		= null;
	private $_newline		= "\r\n";

	private $_connection 	= null;
	private $_errorStack 	= array();
	private $_logStack 		= array();



	public function __construct($smtp_server = 'localhost', $smtp_user = null, $smtp_pass = null, $port = null, $timeout = null) {
		parent::__construct();
		$this->_server = $smtp_server;
		$this->_user = $smtp_user;
		$this->_pass = $smtp_pass;
		$this->_port = $port === null ? self::PORT : $port;
		$this->_timeout = $timeout === null ? self::TIMEOUT : $timeout;

		$this->_connect();


		if ($this->_user !== null && $this->_pass !== null) {
			$this->_authenticate();
		}
	}

	private function _connect() {
		//Connect to the host on the specified port
		$this->_connection = fsockopen($this->_server, $this->_port, $errno, $errstr, $this->_timeout);
		$smtpResponse = fgets($this->_connection, 1024);
		if(empty($this->_connection)) {
			throw new MailException('Failed to connect: ' . $smtpResponse);
		} else {
			$this->_logStack['connection'] = "Connected: $smtpResponse";
		}
		return true;
	}


	private function _authenticate() {
		//Request Auth Login
		fputs($this->_connection, "AUTH LOGIN" . $this->_newline);
		$smtpResponse = fgets($this->_connection, 1024);
		$this->_logStack['authrequest'] = $smtpResponse;

		//Send username
		fputs($this->_connection, base64_encode($this->_user) . $this->_newline);
		$smtpResponse = fgets($this->_connection, 1024);
		$this->_logStack['auth_username'] = $smtpResponse;

		//Send password
		fputs($this->_connection, base64_encode($this->_pass) . $this->_newline);
		$smtpResponse = fgets($this->_connection, 1024);
		$this->_logStack['auth_password'] = $smtpResponse;
		return true;
	}

	 private function _helo() {
		//Say Hello to SMTP
		fputs($this->_connection, "HELO " . $this->_server . $this->_newline);
		$smtpResponse = fgets($this->_connection, 1024);
		$this->_logStack['heloresponse'] = $smtpResponse;
		return true;
	 }


	private function _disconnect() {
		// Say Bye to SMTP
		fputs($this->_connection, "QUIT" . $this->_newline);
		$smtpResponse = fgets($this->_connection, 1024);
		$this->_logStack['quitresponse'] = $smtpResponse;
		fclose($this->_connection);
		return true;
	}

	/**
	 * @todo	An alle Empfänger im Array senden.
	 * @todo	From: Name <adresse@domain.ch> implementieren.
	 * @todo	Header überprüfen. Momentan sind sie leicht fehlerhaft. Im speziellen sind es die FROM, TO und INLINE IMAGE Header.
	 */
	public function sendMail() {
		if (!is_array($this->_to)) {
			throw new MailException('Property MailTransport::to must be a array!');
		}

		$recipient = array_shift($this->_to);
		$subject = $this->_subject;

		if (count($this->_to) > 0) {
			//echo 'noch mehr empfänger' . "\n";
		}

		if ($this->_from !== null) {
			fputs($this->_connection, 'MAIL FROM: ' . $this->_from . $this->_newline);
			$smtpResponse = fgets($this->_connection, 1024);
			$this->_logStack['mailfromresponse'] = $smtpResponse;
		}

		fputs($this->_connection, "RCPT TO: " . $recipient . $this->_newline);
		$smtpResponse = fgets($this->_connection, 1024);
		$this->_logStack['mailtoresponse'] = $smtpResponse;


		//The Email
		fputs($this->_connection, "DATA" . $this->_newline);
		$smtpResponse = fgets($this->_connection, 1024);
		$this->_logStack['data1response'] = $smtpResponse;


		// If charset is null
		if ($this->_charset === null) {
			// Set the default charset
			$this->_charset = $this->_standardCharset;
		}


		$additional_header = $this->_getHeader();
		$body = $this->_getBody();

		fputs($this->_connection, "To: $recipient\nFrom: " . $this->_from . "\nSubject: $subject\n$additional_header\n\n$body\n.\n");

		$smtpResponse = fgets($this->_connection, 1024);
		$this->_logStack['data2response'] = $smtpResponse;
		return true;
	}

	public function debug() {
		$return = '<pre>' . "\n";
		$return .= print_r($this->_logStack, true);
		$return .= print_r($this, true);
		$return .= '</pre>' . "\n";
		return $return;
	}

	public function __destruct() {
		$this->_disconnect();
		return true;
	}
}
?>