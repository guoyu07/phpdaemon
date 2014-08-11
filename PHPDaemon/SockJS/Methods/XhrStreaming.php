<?php
namespace PHPDaemon\SockJS\Methods;
use PHPDaemon\Core\Daemon;
use PHPDaemon\Core\Debug;
use PHPDaemon\Core\Timer;
use PHPDaemon\Utils\Crypt;
/**
 * @package    Libraries
 * @subpackage SockJS
 *
 * @author     Zorin Vasily <maintainer@daemon.io>
 */

class XhrStreaming extends Generic {
	protected $gcEnabled = true;
	protected $contentType = 'application/javascript';
	protected $fillerEnabled = true;
	protected $poll = true;
	protected $pollMode = ['stream'];
	protected $allowedMethods = 'POST';

	protected function sendFrame($frame) {
		if (!$this->preludeSent && substr($frame, 0, 1) !== 'c') {
			$this->preludeSent = true;
			$this->sendFrame(str_repeat('h', 2048));
			$this->bytesSent = 0;
		}
		$this->outputFrame($frame . "\n");
		parent::sendFrame($frame);
	}
}