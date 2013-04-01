<?php

/**
 * Die Abstrakte Klasse MailTransport erweitert die Klasse MailMime
 * und muss zwingend von jedem Transporter implementiert werden.
 * Dem eigentlichen Tranpsorter wird die Abstrakte Funktion sendMail() vorgelegt.
 *
 * @package		Mail
 * @category	Mail
 * @copyright	Copyright (c) 2006 Claudio Walser
 * @author		Claudio Walser
 */
abstract class MailTransport extends MailMime {

	protected $_from = null;
	protected $_replyTo = null;
	protected $_to = array();
	protected $_subject = null;
	protected $_text = null;
	protected $_html = null;
	protected $_attachments = array();
	protected $_inlineImages = array();
	protected $_charset = null;
	protected $_standardCharset = 'iso-8859-1';
	protected $_imageTypes = array(
									'gif'	=> 'image/gif',
									'jpg'	=> 'image/jpeg',
									'jpeg'	=> 'image/jpeg',
									'jpe'	=> 'image/jpeg',
									'bmp'	=> 'image/bmp',
									'png'	=> 'image/png',
									'tif'	=> 'image/tiff',
									'tiff'	=> 'image/tiff',
									'swf'	=> 'application/x-shockwave-flash'
								  );
	protected $_inlineImageStartId = 4700;


	abstract public function sendMail();


	public function __construct() {
		parent::__construct();
	}



	public function setFrom($from) {
		$this->_from = $from;
		return true;
	}

	public function setReplyTo($reply_to) {
		$this->_replyTo = $reply_to;
		return true;
	}



	public function addTo($to) {
		$this->_to[] = $to;
		return true;
	}


	public function setSubject($subject) {
		$this->_subject = $subject;
		return true;
	}


	public function setBodyText($text) {
		$this->_text = $text;
		return true;
	}


	public function setBodyHtml($html) {
		$this->_html = $html;
		return true;
	}


	public function setCharset($charset) {
		$this->_charset = $charset;
		return true;
	}



	public function addAttachment($attachment) {
		if (!file_exists($attachment)) {
			throw new MailException('Cant find the file: <b>' . $attachment . '</b>!');
		}
		$file_name = $attachment;
		$attachment = file_get_contents($attachment);
		$attachment = chunk_split(base64_encode($attachment));
		$this->_attachments[$file_name] = $attachment;
		return true;
	}


	public function addInlineImage($image) {
		if (!file_exists($image)) {
			throw new MailException('Cant find the image: <b>' . $image . '</b>!');
		}

		$exts = explode('.', $image);
		$ext = array_pop($exts);

		if (!isset($this->_imageTypes[$ext])) {
			throw new MailException('Image type <b>' . $ext . '</b> is not allowed for sending!');
		}
		$image_name = $image;
		$image = file_get_contents($image);
		$image = chunk_split(base64_encode($image));
		$this->_inlineImages[$image_name] = $image;
		$cid = $this->_inlineImageStartId + (count($this->_inlineImages) - 1);
		return 'cid:' . $cid;
	}


}

?>