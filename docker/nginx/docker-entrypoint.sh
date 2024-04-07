#!/bin/sh

if [ -L /var/log/nginx/access.log ]; then
    echo "Removing symbolic link from /var/log/nginx/access.log"
    rm /var/log/nginx/access.log
else
    echo "/var/log/nginx/access.log is not a symbolic link or does not exist"
fi