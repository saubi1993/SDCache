<?php
namespace SDClient;

use SDClient\SDConstants;
use SDClient\SDClientProvider;
use SDClient\SDClient;

class SDClientFactory  
{
	private $SDClient;
	private static $instance;

	private function __construct() {

	}

	public static function getInstance() {
		if (!isset(self::$instance)) {
			$class = __CLASS__ ;
			self::$instance = new $class;
		}

		return self::$instance;
	}

	public function getClient() {
		if (is_null($this->SDClient))  { 
			$SDClientProvider = new SDClientProvider();
			$configPath = SDConstants::CONFIG_PATH;

			$this->SDClient = new SDClient($SDClientProvider, $configPath);
		}

		return $this->SDClient;
	}
}

