#!/bin/bash
message="Une sauvegarde par borgmatic vient d'échouer."
msg_content="$message"

url='xxxx'
curl -H "Content-Type: application/json" -X POST -d "{'content\': $msg_content}" $url