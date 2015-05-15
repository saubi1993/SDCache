<?php

namespace eventHandling;

use eventHandling\template;
use eventHandling\consul_template_config;
use eventHandling\SDCacheConstants;
require_once("autoload.php");

    class handler {
        function handle() {
            $event=json_decode(file_get_contents("php://stdin"),true);
            if(sizeof($event)!=0) {
                
                $new_service = base64_decode($event[0]['Payload']);
                echo "Service introduced name is :".$new_service."\n";
                $path=SDCacheConstants::TEMPLATE_PATH.$new_service.".ctmpl";
                
                if (!file_exists($path)) {
                    echo "Adding New Service in service discovery\n"; 
                    $temp_json = new template();
                    $temp_json->templatestring($new_service);
                    
                    $consultemplate=new consul_template_config();
                    $consultemplate->create_config($new_service);
                    
                    shell_exec("pkill -HUP consul-template");
                    echo "Hello waiting for events\n";
                }
                else
                    echo "Service already exists\nHello waiting for events\n";
            }
            else
               echo "Hello waiting for events\n";
        }
    }
    $obj=new handler();
    $obj->handle();
?>