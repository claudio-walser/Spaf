<?php

/**
 * Die Klasse MailTransportSendmail versendet Mail über einen lokalen Sendmail Server
 * und bedient sich dafür der PHP Funktion mail().
 *
 * @package		Mail
 * @category	Mail
 * @subpackage	MailTransporters
 * @copyright	Copyright (c) 2006 Claudio Walser
 * @author		Claudio Walser
 */
class MailTransportSendmail extends MailTransport {

	private $_connection = null;

	function __construct() {
		parent::__construct();
		//$sendmail_path = ini_get('sendmail_path');
		//$this->_connection = popen($sendmail_path . " -t ","w");
	}


	/**
	 * @todo	An alle Empfänger im Array senden.
	 * @todo	From: Name <adresse@domain.ch> implementieren.
	 */
	public function sendMail() {

		if (!is_array($this->_to)) {
			throw new MailException('Property MailTransport::_to must be a array!');
		}


		$recipient = array_shift($this->_to);
		$subject = $this->_subject;


		// BCC finden und definieren
		if (count($this->_to) > 0) {
			//echo 'noch mehr empfänger' . "\n";
		}

		// If charset is null
		if ($this->_charset === null) {
			// Set the default charset
			$this->_charset = $this->_standardCharset;
		}

		$additional_header = $this->_getHeader();
		$body = $this->_getBody();

		/*fputs($this->_connection, "To: " . $recipient);
		fputs($this->_connection, "From: " . $this->_from . "\r\n");
		fputs($this->_connection, "Subject: " . $subject . "\r\n\r\n");
		fputs($this->_connection, $body . "\r\n");
		fputs($this->_connection, $additional_header . "\r\n");*/

		if (mail($recipient,
			 $subject,
			 $body,
			 $additional_header)) {
		} else {
			throw new Exception('Mail ging net raus');
		}
	}

	function debug() {
		return 'no debug function supported yet in sendmail driver';
	}

	function __destruct() {
		//pclose($this->_connection);
	}
}

?>