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

	private $_standardDriver = 'sendmail';
	private $_driver = null;

	function __construct() {
		$this->registerDriver();
	}

	public function setDriver(Transport\Abstraction $driver) {
		$this->_driver = $driver;

		return true;
	}

	public function setBodyText($text) {
		$this->_driver->setBodyText($text);

		return true;
	}

	public function setBodyHtml($html) {
		$this->_driver->setBodyHtml($html);

		return true;
	}

	public function setFrom($from) {
		$this->_driver->setFrom($from);

		return true;
	}

	public function setReplyTo($reply_to) {
		$this->_driver->setReplyTo($reply_to);

		return true;
	}

	public function addTo($to) {
		$this->_driver->addTo($to);

		return true;
	}

	public function setCharset($charset) {
		$this->_driver->setCharset($charset);

		return true;
	}

	public function addInlineImage($image) {
		return $this->_driver->addInlineImage($image);
	}

	public function addAttachment($attachment) {
		$this->_driver->addAttachment($attachment);

		return true;
	}

	public function setSubject($subject) {
		$this->_driver->setSubject($subject);

		return true;
	}

	public function sendMail() {
		$this->_driver->sendMail();

		return true;
	}

	public function debug() {
		return $this->_driver->debug();
	}

}

?>