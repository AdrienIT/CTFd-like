#!/bin/bash

mkdir /tmp/chall

test="$(ls backend/public/files/ | grep .\zip$ |head -1| sed -n 's/.zip//p')"

mv backend/public/files/${test}.zip /tmp/chall

mkdir /tmp/chall/${test}

unzip /tmp/chall/${test}.zip -d /tmp/chall/${test}

#vagrant init /tmp/chall/${test}/

cd /tmp/chall/${test}/${test}
vagrant up ${test}
