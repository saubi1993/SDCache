<?php
namespace InitializeCache;
require_once("autoload.php");
use InitializeCache\template;
use InitializeCache\consul_template_config;

class InitializeCache {
	
	function httpGet() {
	    $ch = curl_init();  
	 	$url = "http://localhost:8500/v1/catalog/services";
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    $output=curl_exec($ch);
	 
	    curl_close($ch);
	    return $output;
	}
	
	function makeCache() {
		$services = json_decode($this->httpGet() ,true);
		print_r($services);

		foreach ($services as $key => $value) {
			if(strcmp($key,"consul")!=0) {
				consul_template_config::create_config($key);
				template::templatestring($key);
			}
		}
		shell_exec("pkill -HUP consul-template");
	}

}
$obj = new InitializeCache;
$obj->makeCache();