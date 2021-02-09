#!/bin/bash

#dependencies
sudo apt install -y nodejs
sudo apt install npm

#Install netdata
bash <(curl -Ss https://my-netdata.io/kickstart.sh) --dont-wait

# curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -


# start server
npm install web --prefix web/
npm install backend --prefix backend/

npm start --prefix backend/
npm start --prefix web/

