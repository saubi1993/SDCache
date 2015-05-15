<?php
namespace eventHandling;
use eventHandling\SDCacheConstants;

		require_once("autoload.php");

		$file_name = $argv[1];
		$input = json_decode(file_get_contents(SDCacheConstants::JSON_SERVICE_CONFIG.$file_name.".json"),true);
		$output="<?php \n \$information = ";
		$output .= var_export($input, true) . " ;";
		file_put_contents(SDCacheConstants::PHP_SERVICE_CONFIG.$file_name.".php", $output);
