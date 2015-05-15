#!/bin/bash
sudo rm -rf ../service
sudo mkdir -p ../service/current/templates
sudo mkdir -p ../service/current/configs/php
sudo mkdir -p ../service/current/configs/json
sudo rm -rf ./consulClientMode/agentState
sudo rm -rf ./consulServerMode/agentState
sudo chmod -R 777 ../service
sudo chmod -R 777 ../SDCachelibrary
cat > ./consul-template/config/consul-template.cfg <<EOF1
consul = "127.0.0.1:8500"
wait = "3s"
EOF1
