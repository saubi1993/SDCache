<?php
		namespace eventHandling;
		use eventHandling\SDCacheConstants;

		require_once("autoload.php");

		$file_name = $argv[1];
		$input = file_get_contents(SDCacheConstants::JSON_SERVICE_CONFIG.$file_name.".json");	
		$output = preg_replace("/,]/", "\n    ]",$input);
		$output = preg_replace("/,}/", "\n    }",$output);
		file_put_contents(SDCacheConstants::JSON_SERVICE_CONFIG.$file_name.".json", $output);
		
