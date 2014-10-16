<?php

/**
 * $Id$
 *
 * Spaf/Library/Mail/Manager.php
 * @created Tue Nov 13 18:02:06 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Mail;

/**
 * \Spaf\Library\Mail\Manager
 *
 * Basic mail manager class to send mails with a supported transport driver.
 * Currently there is a sendmail driver and a propietary smtp driver
 *
 * @author Claudio Walser
 * @package Spaf\Library\Log
 * @namespace Spaf\Library\Log
 */
class Manager {

	private $_standardTransport = null;
	private $_transport = null;

	function __construct() {
		$this->_standardTransport = new Transport\Sendmail();
		$this->_transport = $this->_standardTransport;
	}

	public function setTransport(Transport\AbstractTransport $transport) {
		$this->_transport = $transport;

		return true;
	}

	public function setBodyText($text) {
		$this->_transport->setBodyText($text);

		return true;
	}

	public function setBodyHtml($html) {
		$this->_transport->setBodyHtml($html);

		return true;
	}

	public function setFrom($from) {
		$this->_transport->setFrom($from);

		return true;
	}

	public function setReplyTo($reply_to) {
		$this->_transport->setReplyTo($reply_to);

		return true;
	}

	public function addTo($to) {
		$this->_transport->addTo($to);

		return true;
	}

	public function setCharset($charset) {
		$this->_transport->setCharset($charset);

		return true;
	}

	public function addInlineImage($image) {
		return $this->_transport->addInlineImage($image);
	}

	public function addAttachment($attachment) {
		$this->_transport->addAttachment($attachment);

		return true;
	}

	public function setSubject($subject) {
		$this->_transport->setSubject($subject);

		return true;
	}

	public function sendMail() {
		$this->_transport->sendMail();

		return true;
	}

	public function debug() {
		return $this->_transport->debug();
	}

}

?>