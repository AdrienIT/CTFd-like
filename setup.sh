#!/bin/bash

#Check if script started as root.
if [ "$EUID" -ne 0 ]
then echo "Please run as root"
  exit
fi

#Get variables from .env files
set -o allexport
source .env
set +o allexport



#Check if mysql is installed
if ! [ -x "$(command -v mysql)" ]; then
  echo "Mysql isn't installed" >&2
  read -p "Would you like to install it ? (Y/N) : "confirm && [[ $confirm == [yY] || $confirm == [yY][eE][sS] ]] || exit 1
  apt install -y mysql
  exit
  else
   echo "Mysql is already installed"
fi

#Check if docker is installed
DOCKER=$(pgrep docker | wc -l);
if [ "$DOCKER" -ne 1 ]; then
  echo "Docker isn't installed";
  read -p "Would you like to install it ? (Y/N) : "confirm && [[ $confirm == [yY] || $confirm == [yY][eE][sS] ]] || exit 1
  apt install -y docker-ce docker-ce-cli containerd.io
  exit
  else
   echo "Docker is already installed"
fi

#Check if apache2 is installed.
if ! [ -x "$(command -v apache2)" ]; then
  echo "Apache2 isn't installed" >&2
  sudo apt install -y apache2 php php-fpm php-pdo php-zip php-mysql
  exit
  else
   echo "Apache2 is already installed"
fi

#check if borgbackup and borgmatic are installed
if ! [ -x "$(command -v borgbackup)" ]; then
  echo "borgbackup isn't installed" >&2
  read -p "Would you like to install it ? (Y/N) : "confirm && [[ $confirm == [yY] || $confirm == [yY][eE][sS] ]] || exit 1
  apt install -y borgbackup
  exit
  else
  if ! [ -x "$(command -v borgmatic)" ]; then
    echo "borgmatic isn't installed" >&2
    read -p "Would you like to install it ? (Y/N) : "confirm && [[ $confirm == [yY] || $confirm == [yY][eE][sS] ]] || exit 1
    apt install -y borgmatic
    exit
  else
    echo "Both Borgmatic and Borgbackup are installed"
    mkdir /opt/backup/backup
    mkdir /opt/backup/scripts
    PWD=/opt/backup/scripts
    /usr/bin/borg init -e none /opt/backup/backup
    mv ./test.yaml /opt/backup/scripts/
    mv ./successbackup.sh /opt/backup/scripts/
    mv ./errorbackup.sh /opt/backup/scripts/
    read -p "Enter discord webhook for backups alerts: " discordwebhook
    sed -i "/url=/c\url='$discordwebhook" /usr/lib/netdata/conf.d/health_alarm_notify.conf  /opt/backup/scripts/successbackup.sh
    sed -i "/url=/c\url='$discordwebhook" /usr/lib/netdata/conf.d/health_alarm_notify.conf  /opt/backup/scripts/errorbackup.sh
    chmod +x /opt/backup/scripts/successbackup.sh
    chmod +x /opt/backup/scripts/errorbackup.sh

    mv ./systemd/borgmatic.timer /etc/systemd/system/borgmatic.timer
    mv ./systemd/borgmatic.service /etc/systemd/system/borgmatic.service

    systemctl daemon-reload
  fi
fi

#change user and pass init pdo 
sed -i "/\$database_user=/c\$database_user='$MYSQL_USER';" ./bdd.php
sed -i "/\$database_password=/c\$database_password='$MYSQL_PASSWORD';" ./bdd.php

#Check if netdata is installed
if ! [ -x "$(command -v netdata)" ]; then
  echo "Netdata isn't installed" >&2
  read -p "Would you like to install it ? (Y/N) : "confirm && [[ $confirm == [yY] || $confirm == [yY][eE][sS] ]] || exit 1
  bash <(curl -Ss https://my-netdata.io/kickstart.sh) --dont-wait
  read -p "Enter discord webhook for alert: " discordwebhook
  sed -i "/DISCORD_WEBHOOK_URL=/c\DISCORD_WEBHOOK_URL='$discordwebhook" /usr/lib/netdata/conf.d/health_alarm_notify.conf
fi

#Check if apache and mysql are running
APACHESTATUS="$(systemctl is-active apache2)"
MYSQLSTATUS="$(systemctl is-active mysql)"
if [ "${APACHESTATUS}" = "active" ]; then
    if [ "${MYSQLSTATUS}" = "active" ]; then
	echo "Apache and Mysql are running"
    else
        echo "Mysql is not running, starting it for you ..."
        systemctl start mysql
        echo "mysql is now started"
fi
else
    echo "Apache 2 is not running, starting it for you ..."
    systemctl start apache2
    echo "apache2 is now started"
    if [ "${MYSQLSTATUS}" = "active" ]; then
        echo "Apache and Mysql are running"
    else
        echo "Mysql is not running, starting it for you ..."
        systemctl start mysql
        echo "mysql is now started"
    fi
fi

#Check if netdata is running
NETDATASTATUS="$(systemctl is-active netdata)"
if [ "${NETDATASTATUS}" = "active" ]; then
	echo "Netdata is installed and running"
else
        echo "Netdata is not running, starting it for you ..."
        systemctl start netdata
        echo "Netdata is now started"
fi

#Generate bcrypt password for admin page
if ! [ -x "$(command -v htpasswd)" ]; then
  read -p "Would you like to install it ? (Y/N) : "confirm && [[ $confirm == [yY] || $confirm == [yY][eE][sS] ]] || exit 1
  apt install -y htpasswd
  BCRYPTPASSWD=$(htpasswd -bnBC 10 "" $ADMIN_PASSWORD | tr -d ':\n')
else
  BCRYPTPASSWD=$(htpasswd -bnBC 10 "" $ADMIN_PASSWORD | tr -d ':\n')
fi

#Executing sql commands
mysql -h "localhost" "--user=root" "--password=root" -e \
	"SET PASSWORD FOR 'root'@'localhost' = PASSWORD('$MYSQL_ROOT_PASSWORD');" -e \
	"CREATE DATABASE IF NOT EXISTS ctfdlike CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';" -e \
	"USE ctfdlike;" -e \
	"CREATE TABLE IF NOT EXISTS \`users\` (\`users_id\` int NOT NULL AUTO_INCREMENT,\`username\` varchar(50) NOT NULL,\`password\` varchar(255) NOT NULL,\`email\` varchar(50) DEFAULT NULL,\`token\` varchar(50) DEFAULT NULL,\`isVerified\` boolean default false, PRIMARY KEY (\`users_id\`),UNIQUE KEY \`username\` (\`username\`),UNIQUE KEY \`email\` (\`email\`));" -e \
	"CREATE TABLE IF NOT EXISTS \`admin\` (\`admin_id\` int NOT NULL AUTO_INCREMENT,\`username\` varchar(50) NOT NULL,\`password\` varchar(255) NOT NULL, PRIMARY KEY (\`admin_id\`),UNIQUE KEY \`username\` (\`username\`));" -e \
  "CREATE TABLE IF NOT EXISTS \`challenges\` (\`id\` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,\`name\` varchar(255) NOT NULL,\`categorie\` varchar(255) NOT NULL,\`description\` text NOT NULL,\`data\` text,\`hint\` text,\`flag\` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;" -e \
	"INSERT INTO admin (username, password) VALUES('$ADMIN_USER','$BCRYPTPASSWD');" -e \
	"FLUSH PRIVILEGES;"

# Move github web files to /var/www/html/
yes | cp -rf * /var/www/html

#open netdata port
iptables -A INPUT -p tcp -m tcp --dport 19999 -j ACCEPT

echo -e "www-data  ALL=NOPASSWD: /bin/docker, /bin/curl" >> /etc/sudoers
echo "Installation completed with success"

#echo "ça work"


