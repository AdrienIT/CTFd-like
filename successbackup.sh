#!/bin/bash
message="Une sauvegarde par borgmatic vient d'avoir lieu avec succès."
msg_content="$message"

url='xxxx'
curl -H "Content-Type: application/json" -X POST -d "{'content\': $msg_content}" $url