<?php
namespace InitializeCache;
use InitializeCache\SDCacheConstants;

	class consul_template_config{
        
        function create_config($new_service){
	          $fixerPath= SDCacheConstants::PHP_EVENT_HANDLER;
            $fix_json =$fixerPath."fix_json.php" ;
            $fix_php =$fixerPath."fix_php.php" ;
            $string = file_get_contents(SDCacheConstants::CONSUL_TEMPLATE_PATH);
            $string.= <<<cmd

template {
  source = "/apps/service/current/templates/$new_service.ctmpl"
  destination = "/apps/service/current/configs/json/$new_service.json"
  command = "php $fix_json $new_service ; php $fix_php $new_service "
}

cmd;
            file_put_contents(SDCacheConstants::CONSUL_TEMPLATE_PATH,$string);
        }
	}