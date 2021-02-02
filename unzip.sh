#!/bin/bash

mkdir /tmp/upload

mkdir /tmp/chall

test="$(ls /tmp/upload | grep .\zip$ |head -1| sed -n 's/.zip//p')"

mkdir /tmp/chall/${test}

unzip /tmp/upload/${test}.zip -d /tmp/chall/${test}

#vagrant init /tmp/chall/${test}/

cd /tmp/chall/${test}/${test}
vagrant up ${test}
