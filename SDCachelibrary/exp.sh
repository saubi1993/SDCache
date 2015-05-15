#!/bin/bash
sudo rm -rf discovery/current
sudo mkdir -p discovery/current/templates
sudo mkdir -p discovery/current/configs/php
sudo mkdir -p discovery/current/configs/json

sudo chmod -R 777 discovery/
name=$(who -m | awk '{print $1;}')
server="false"
join=""
bootstrap="false"
flag=0
ip=$(echo `ifconfig eth0 2>/dev/null|awk '/inet addr:/ {print $2}'|sed 's/addr://'`)
while [[ $# > 0 ]]
do
key="$1"
 
case $key in
    -name)
    name="$2"
    shift
    ;;
    -server)
    server="$2"
  	shift
    ;;
    -join)
    join="-join=$2"
    shift
    ;;
    -boot)
    bootstrap="true"
    ;;
    -ip)
    ip="$2"
    shift
    ;;
    *)
		  echo "Enter correct flags"
          flag=1
    ;;
esac
shift
done

if [[ $flag == 1 ]]; then
	exit
fi


cat > ./config.json <<EOF1
{
    "server": $server,
    "datacenter": "dc1",
    "data_dir": "/tmp/consul",
    "ui_dir": "/ui/dist/",
    "node_name": "$name",
    "client_addr": "0.0.0.0",
    "advertise_addr": "$ip",
    "bootstrap": $bootstrap,
    "recursor": "8.8.8.8",
    "dns_config":{
		"allow_stale":true,
		"service_ttl":{
		 	"*": "10s"		
		},
		"node_ttl": "10s"
    }
}
EOF1

sudo docker pull docker.infoedge.com:5000/naukri/consul


cat > ./config/consul.conf <<EOF1

[program:consul]
command=consul agent -config-dir /consul $join 

[program:consul-template]
command=consul-template -config /consul/consul-template/config/consul-template.cfg

[program:watch]
command=consul watch -type=event -name=service /consul/service_discovery_lib/handler.sh
EOF1

cat > ./consul-template/config/consul-template.cfg <<EOF1
consul = "127.0.0.1:8500"
wait = "3s"
EOF1
sudo docker-compose up 
