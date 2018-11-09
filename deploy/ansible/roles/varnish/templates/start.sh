#!/bin/sh
set -xe

varnishd -a :81 -f /etc/varnish/default.vcl -s malloc,256m

