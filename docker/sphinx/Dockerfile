FROM alpine:latest
MAINTAINER Malikov A.V. <alexrettvm@gmail.com>

#ADD sphinx.conf /etc/sphinx/sphinx.conf

RUN apk --update add sphinx \
	&& mkdir -p /var/lib/sphinx \
	&& mkdir -p /var/lib/sphinx/data \
	&& mkdir -p /var/log/sphinx \
	&& mkdir -p /var/run/sphinx

#RUN touch /etc/sphinx/sphinx.conf

EXPOSE 9306

