FROM 		docker.infoedge.com:5000/naukri/php_nginx_build
MAINTAINER 	Saurabh Kushwaha <saubi1993@gmail.com>

ENV consul_version 0.5.0_linux_amd64.zip
ENV consul_temp_version v0.9.0/consul-template_0.9.0_linux_amd64.tar.gz
ENV web_ui 0.5.0_web_ui.zip
ENV template consul-template_0.9.0_linux_amd64



ADD https://github.com/hashicorp/consul-template/releases/download/$consul_temp_version /tmp/consul-template.tar.gz
RUN cd /bin && tar -zxvf /tmp/consul-template.tar.gz && mv $template/consul-template /bin/  &&chmod +x /bin/consul-template && rm /tmp/consul-template.tar.gz


ADD https://dl.bintray.com/mitchellh/consul/$consul_version /tmp/consul.zip
RUN cd /bin && unzip /tmp/consul.zip && chmod +x /bin/consul && rm /tmp/consul.zip


ADD https://dl.bintray.com/mitchellh/consul/$web_ui /tmp/webui.zip
RUN mkdir /ui && cd /ui && unzip /tmp/webui.zip && rm /tmp/webui.zip 

RUN mkdir -p /apps/service/current/configs/json
RUN mkdir -p /apps/service/current/configs/php
RUN mkdir -p /apps/service/current/templates

#ADD ./config /config/
#ONBUILD ADD ./config /config/

#ADD ./start /bin/start
#ADD ./check-http /bin/check-http
#ADD ./check-cmd /bin/check-cmd

#EXPOSE 8300 8301 8301/udp 8302 8302/udp 8400 8500 53/udp
#VOLUME ["/data"]

#ENV SHELL /bin/bash

ENTRYPOINT ["supervisord"]
#CMD []
