#!/bin/bash

test="$(ls /tmp/upload | grep .\zip$ |head -1| sed -n 's/.zip//p')"

mkdir /tmp/chall/${test}

unzip /tmp/upload/${test}.zip -d /tmp/chall/${test}

