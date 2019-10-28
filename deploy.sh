#!/bin/bash

#########################################
echo "Zip website"
#########################################
rm -f ./website.zip
zip -r website.zip ./src/ ./public/ ./composer.json

#########################################
echo "Send website.zip to remote: 67.205.189.5"
#########################################
scp ./website.zip root@67.205.189.5:/home
rm ./website.zip

#########################################
echo "[Remote] Unzip website.zip"
#########################################
ssh root@67.205.189.5 'cp /home/website.zip /var/www/website/ && cd /var/www/website/ && unzip -o /home/website.zip'

#########################################
echo "[Remote] Chmod 777"
#########################################
ssh root@67.205.189.5 'chmod -R 777 /var/www/website/'

#########################################
echo "[Remote] Chown www-data"
#########################################
ssh root@67.205.189.5 'chown -R www-data:www-data /var/www/website/'

