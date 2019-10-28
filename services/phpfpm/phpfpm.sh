#!/bin/bash

cd /www/

# mysql -hmysqldb -uroot -proot -e "CREATE DATABASE webwallet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# bin/console doctrine:schema:create

# if [[ $(bin/console doctrine:migrations:status | grep 'Already at latest version' | wc -l) -eq 0 ]]; then
#     echo "[api] Migrate SQL database"
#     bin/console doctrine:schema:update --dump-sql --force && bin/console doctrine:migrations:migrate
# else
#     echo "[api] SQL migrations already applied"
# fi


# while [[ 1 ]]; do
# 	sleep 1
# done
