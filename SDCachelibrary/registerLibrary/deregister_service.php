<?php 
    
    class deregisterService 
    {    
         private $serviceID;
         private $node;

         function __construct($id , $name ,$tag , $node) {
            $this->serviceID=$name."/".$tag."/".$id;
            $this->node=$node;
         }

        private function curl_put($data_string) { 
            $url ="http://localhost:8500/v1/catalog/deregister";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                         
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($data_string))                                                                       
            ); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);       
        }
        
        private function curl_del()
        {

            $url ="http://localhost:8500/v1/kv/".$this->serviceID."?recurse";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_exec($ch);
            curl_close($ch);
        }

        public function deregister() {
            $data_string= <<<cmd
    {
        "Node": "$this->node",
        "ServiceID": "$this->serviceID"
    }
cmd;
            $this->curl_del();
            $this->curl_put($data_string);   
        }
    }

    $obj = new deregisterService("1","webs","tag1","testing") ;
    $obj->deregister();