#!/bin/bash

set -x

touch /etc/php/5.6/php-env-vars.conf
truncate -s 0 /etc/php/5.6/php-env-vars.conf

chown www-data:root /etc/php/5.6/php-env-vars.conf
chmod +x /etc/php/5.6/php-env-vars.conf
chmod 755 -R /etc/php/5.6/php-env-vars.conf
      
if [ -z ${MYSQL_DB_HOST+foobar} ];
then
    echo "MYSQL_DB_HOST_ENV_VAR_IS_EMPTY"
else
echo "env[MYSQL_DB_HOST] = $MYSQL_DB_HOST;" >>  /etc/php/5.6/php-env-vars.conf
fi

if [ -z ${MYSQL_DB_USER+foobar} ];
then
    echo "MYSQL_DB_USER_ENV_VAR_IS_EMPTY"
else
echo "env[MYSQL_DB_USER] = $MYSQL_DB_USER;" >>  /etc/php/5.6/php-env-vars.conf
fi

if [ -z ${MYSQL_DB_PASSWORD+foobar} ];
then
    echo "MYSQL_DB_PASSWORD_ENV_VAR_IS_EMPTY"
else
echo "env[MYSQL_DB_PASSWORD] = $MYSQL_DB_PASSWORD;" >>  /etc/php/5.6/php-env-vars.conf
fi

if [ -z ${MYSQL_DB_NAME+foobar} ];
then
    echo "MYSQL_DB_NAME_ENV_VAR_IS_EMPTY"
else
echo "env[MYSQL_DB_NAME] = $MYSQL_DB_NAME;" >>  /etc/php/5.6/php-env-vars.conf
fi
