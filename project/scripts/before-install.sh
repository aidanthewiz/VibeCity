#!/bin/bash

if [ -d /var/www/temp ]; then
    until [ -z "$(ls -A /var/www/temp)" ]
    do
        sleep 2
    done
else
    >&2 echo "ERROR: /var/www/temp DOES NOT EXIST"
	exit 1
fi

exit 0
