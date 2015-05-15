<?php 
	require_once('jsonValidate.php');
	class register {

		private $register_url;
		private $event_url;
		
		function __construct() {
				$this->register_url = 'http://localhost:8500/v1/agent/service/register';  
				$this->event_url = 'http://localhost:8500/v1/event/fire/service';
		}

		public function curl_put($data_string,$url,$register) {	
	        $ch = curl_init($url);
			if($register==true) {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                         
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			    	'Content-Type: application/json',                                                                                
			    	'Content-Length: ' . strlen($data_string))                                                                       
				);     
			}
			else 
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}

		public function insertServiceKValues($id , $key , $value) {
    		$key_url= <<<cmd
http://localhost:8500/v1/kv/$id/$key
cmd;
    			$this->curl_put($value,$key_url,false);
		}

		public function insertServiceDefinition($id , $name , $tags , $ip , $port ,$interval) {
			$data_string= <<<cmd
  			{"id": "$id","name": "$name", "tags": ["$tags"],"address": "$ip", "port":$port,
  			"check": {"script": "curl http://$ip:$port >/dev/null 2>&1", "interval": "$interval"}}
cmd;

            $this->curl_put($data_string,$this->register_url,true);

		}

		public function fireEvent($eventName) {
			$data_string = <<<cmd
$eventName
cmd;
			$this->curl_put($data_string,$this->event_url,false);
		}

		public function registerService($configPath ,$interval = "5s") {
			
			$serviceInfo=file_get_contents($configPath);
			$obj=new jsonValidate;
			$json=$obj->decode($serviceInfo);
			$obj->Set($json) ;
			
			$ip =$json["ip"];
			$name =$json["name"];
			$id =$json["id"];
			$tags =$json["tag"];
			$port = $json["port"];
			$weight = $json["weight"];
			$protocol = $json["protocol"];
			$endpoints = json_encode($json["endpoints"]);
			$id = $name."/".$tags."/".$id ;
			$this->insertServiceDefinition( $id , $name , $tags , $ip , $port ,$interval);
			
			$this->insertServiceKValues($id , "weight" ,"\"".$weight."\"");
			$this->insertServiceKValues($id , "protocol" ,"\"".$protocol."\"");
			$this->insertServiceKValues($id , "endpoints" ,$endpoints);
  
			$this->fireEvent($name);
			$this->fireEvent($name);					
		}
	}



	$obj=new register();
	try {
	$obj->registerService("serviceConfig.json");
	}
	catch (Exception $e) {
				echo $e->getMessage();
	}

