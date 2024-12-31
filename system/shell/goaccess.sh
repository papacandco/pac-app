!#/usr/bin/env bash

goaccess /papac-and-co/logs/app-production.access.log \
	-o /papac-and-co/console-production/resources/views/vendor/report.html \
	--log-format=COMBINED \
	--real-time-html \
	--port=7890 \
	--addr=0.0.0.0 \
	--daemonize
