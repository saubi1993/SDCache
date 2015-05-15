<?php 

	function __autoload($class) { 
	     	$parts = explode('\\', $class);
	    		require_once end($parts) . '.php'; 
	}
