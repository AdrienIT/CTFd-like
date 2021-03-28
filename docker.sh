#!/bin/bash

challname=$(cat /var/www/html/challname | awk -F'/' '{print $NF}')
challnamelow=$(cat /var/www/html/challname | awk -F'/' '{print $NF}' | awk '{print tolower($0)}')

echo "$challname"

sudo docker build -t "$challnamelow" /var/www/html/"$challname" 
sudo docker run -d --publish-all --name "$challnamelow" "$challnamelow":latest
port=$(docker port "$challnamelow" | awk -F':' '{print $NF}')

echo "You challenge is running on port : $port"