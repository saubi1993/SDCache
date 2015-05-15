## To setup consul and SDCache , follow the following commands ::

* Download consul binary from  	https://consul.io/downloads.html

* Download Consul-template binary from 	https://github.com/hashicorp/consul-template/releases 

* Copy those binaries in /usr/local/bin with executable permission.

* Check Consul and Consul Template is installed correctly by typing following in the terminal.
```sh
consul --version
consul-template --version
```



## To setup SDCacheLibrary ::
- Enter the following commands in terminal.

```sh
sudo git clone http://gitlab.infoedge.com/s.kushwaha/SDCache.git /apps
cd /apps/SDCachelibrary
./reset.sh
```



## To start consul agent in client mode ::
    
Change the node name of consul client in client configuration, according to host machine.     
```sh
vi /apps/SDCachelibrary/consulClientMode/config.json
```


Type the following in terminal to start consul client agent :
```sh
cd /apps/SDCachelibrary/
./reset.sh    
consul agent -config-dir /apps/SDCachelibrary/consulClientMode
```   
  
  To change consul client configuration , simply edit /apps/SDCachelibrary/consulClientMode/config.json





## To start consul agent in server mode ::

  Change the node name of consul server in server configuration, according to host machine.     
```sh
vi /apps/SDCachelibrary/consulServerMode/config.json
```    
Type the following in terminal to start consul server agent :
```sh
cd /apps/SDCachelibrary/
./reset.sh
consul agent -config-dir /apps/SDCachelibrary/consulServerMode
```
  To change consul server configuration , simply edit /apps/SDCachelibrary/consulServerMode/config.json









## To start SDCache

* Start consul agent { refer (3) point }
* Then enter following commands in terminal :

```sh
cd /apps/SDCachelibrary/
```
Either enter the consul watch configuration in consul agent's configuration or type the following in terminal to start consul watch:
```sh
consul watch -type=event -name=service ./eventHandling/handler.sh
```
```sh
consul-template -config consul-template/config/consul-template.cfg
```




## To Register Service
```sh
	cd /apps/SDCachelibrary/registerLibrary
```
Edit the serviceConfig.json and enter the configuration of service correctly in the specified manner and run 
```sh
    php register.php
```

`` Service registeration shoud be done from that consul agent where service is running.
``





## To Deregister Service
```sh
	cd /apps/SDCachelibrary/registerLibrary
```
Open deregister.php . Change the object creation line in end of deregister.php like as follows 
```sh
	$obj = new deregisterService($id , $name ,$tag , $node) ;
```
	id = unique id of service given at the time of registeration of service.
	name = Name of service.
	tag = Tag of service which can be version number.
	node = Host machine name or name of consul agent from which service was registered.
like as follows :

	$obj = new deregisterService("1","Filestorageservice","2.3","Rishu") ;
   


## To join in an existing cluster 
	
Start consul agent.  
Setup SDCache. 
Join the existing cluster by following command .

* ip = IP of any cluster member .
* port = PORT for serf-lan for an agent

```sh
consul join ip:port
```
like 

```sh
consul join 192.168.2.116:8301
```

Run following commands in terminal to setup sync with SDCache of others.

	cd /apps/SDCachelibrary/InitializeCache
	php InitializeCache.php



   

## To gracefully stop the consul agent 
	
Remember to deregister all services running on that node so that services entries is removed properly from consul.
	Then in terminal type 

	consul leave
	cd /apps/SDCachelibrary/
	./reset.sh