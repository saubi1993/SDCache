<?php
	
	use SDClient\SDClientFactory;
	use SDClient\SDConfigNotFoundException;
	function __autoload($class) { 
     	$parts = explode('\\', $class);
    		require_once end($parts) . '.php';
	} 
	
	try {
		$service=SDClientFactory::getInstance()->getClient()->discoverAll("web");
		print_r($service);
	}
	catch (SDConfigNotFoundException $e) {
				echo $e->getMessage();
	} 
	try {
		$service=SDClientFactory::getInstance()->getClient()->discover("web" ,  "tag1" );
		print_r($service);
	}
	catch (SDConfigNotFoundException $e) {
				echo $e->getMessage();
	}
	try {
		$service=SDClientFactory::getInstance()->getClient()->discover("web" ,  "tag1" , "book" );
		print_r($service);//$endpoint="health";
	}
	catch (SDConfigNotFoundException $e) {
				echo $e->getMessage();
	}
	try {
		$service=SDClientFactory::getInstance()->getClient()->discover("random", "web/tag2");
		print_r($service);
	}
	catch (SDConfigNotFoundException $e) {//echo "\n hello \n";
				echo $e->getMessage();
	}
	try {
		$service=SDClientFactory::getInstance()->getClient()->discover("web");
		print_r($service);
	}
	catch (SDConfigNotFoundException $e) {
				echo $e->getMessage();

	}
	    
