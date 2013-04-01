<?php

/**
 * Die Abstrakte Klasse MailMime wird von MailTransport erweitert und kümmert sich um die MailHeader.
 * Jeder eigentliche Transporter hängt von der MailTransport Klasse ab
 * und kann sich somit dieser Funktionen bedienen.
 *
 * @package		Mail
 * @category	Mail
 * @copyright	Copyright (c) 2006 Claudio Walser
 * @author		Claudio Walser
 */
abstract class MailMime {


	protected $_seperator = null;
	protected $_file_object = null;


	protected function __construct() {
		$this->_seperator = strtoupper(md5(uniqid(time())));
		//$this->_file_object = new FileObject();
	}


	protected function _getHeader() {
		// If minimum one attachment exists.
		if (count($this->_attachments) > 0 || count($this->_inlineImages) > 0) {
			$additional_header = '';
			if ($this->_from !== null) {
				$additional_header .= 'From: ' . $this->_from . "\r\n";
			}
			if ($this->_replyTo !== null) {
				$additional_header .= 'Reply-To: ' . $this->_replyTo . "\r\n";
			} else {
				$additional_header .= 'Reply-To: ' . $this->_from . "\r\n";
			}

			if (count($this->_inlineImages) > 0) {
				// Content type for inline images
				$additional_header .= 'Content-Type: multipart/related;' . "\n";
			} else {
				// Content type for simple attachments
				$additional_header .= 'Content-Type: multipart/mixed;' . "\n";
			}
			$additional_header .= ' boundary="' . $this->_seperator . '"' . "\n\n";

		} else {
			$additional_header = '';
			// send normal text or html mail
			if ($this->_from !== null) {
				$additional_header .= 'From: ' . $this->_from . "\r\n";
			}

			if ($this->_replyTo !== null) {
				$additional_header .= 'Reply-To: ' . $this->_replyTo . "\r\n";
			} else {
				$additional_header .= 'Reply-To: ' . $this->_from . "\r\n";
			}
			if ($this->_html === null && $this->_text !== null) {
				$additional_header .= 'Content-Type: text/plain; charset=' . $this->_charset . "\r\n";
			} else  if ($this->_html !== null && $this->_text === null) {
				$additional_header  .= 'Content-Type: text/html; charset=' . $this->_charset . "\r\n";
			} else {
				throw new MailException('Cant send text and html message!');
			}
			$additional_header .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
		}
		return $additional_header;
	}

	protected function _getBody() {
		$body = null;
		// If minimum one attachment exists.
		if (count($this->_attachments) > 0 || count($this->_inlineImages) > 0) {
			$body = '--' . $this->_seperator . "\n";

			if ($this->_html === null && $this->_text !== null) {
				$body .= 'Content-Type: text/plain; charset=\"' . $this->_charset . '"' . "\n";
				$body .= 'Content-Transfer-Encoding: 32bit' . "\n\n";
				$body .= $this->_html;
				$body .= "\n\n";
			} else  if ($this->_html !== null && $this->_text === null) {
				$body .= 'Content-Type: text/html; charset="' . $this->_charset . '"' . "\n";
				$body .= "Content-Transfer-Encoding: 32bit\n\n";
				$body .= $this->_html;
				$body .= "\n\n";
			} else {
				throw new MailException('Cant send text and html message!');
			}

			if (count($this->_attachments) > 0) {
				foreach ($this->_attachments as $filename => $file_content) {
					$body .= '--' . $this->_seperator . "\n";
					$body .= 'Content-Type: MIME-Version: 1.0; name="' . $filename . '"' . "\n";
					$body .= 'Content-Transfer-Encoding: base64' . "\n";
					$body .= 'Content-Disposition: attachment; filename="' .$filename . '"' . "\n\n";
					$body .= $file_content;
					$body .= "\n\n\n" . '--' . $this->_seperator . "\n";
				}
			}


			if (count($this->_inlineImages) > 0) {
				$cid = $this->_inlineImageStartId;
				$cids_array = array();
				foreach ($this->_inlineImages as $imagename => $image_content) {
					$exts = explode('.', $imagename);
					$ext = array_pop($exts);
					if (isset($this->_imageTypes[$ext])) {
						$image_type = $this->_imageTypes[$ext];
					}
					$body .= '--' . $this->_seperator . "\n";
					$body .= 'Content-ID:' . $cid . "\n";
					$body .= 'Content-Type: ' . $image_type . '; name="' . $imagename . "\"\n";
					$body .= "Content-Transfer-Encoding: base64\n";
					$body .= "Content-Disposition: attachment; filename=\"" . $imagename . "\"\n\n";
					$body .= $image_content;
					$body .= '--' . $this->_seperator . "\n";
					$cids_array[] = $cid;
					$cid++;
				}
			}


		} else {
			if ($this->_html === null && $this->_text !== null) {
				$body = $this->_text;
			} else  if ($this->_html !== null && $this->_text === null) {
				$body = $this->_html;
			} else {
				throw new MailException('Cant send message without text!');
			}
		}
		return $body;
	}

}


?>