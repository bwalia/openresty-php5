#!/bin/bash

set -x

if [ -z ${MYSQL_DB_HOST+foobar} ];
then
    echo "MYSQL_DB_HOST_ENV_VAR_IS_EMPTY"
else
echo "env[MYSQL_DB_HOST] = $MYSQL_DB_HOST;" >>  /usr/local/etc/php-fpm.conf
fi

if [ -z ${MYSQL_DB_USER+foobar} ];
then
    echo "MYSQL_DB_USER_ENV_VAR_IS_EMPTY"
else
echo "env[MYSQL_DB_USER] = $MYSQL_DB_USER;" >>  /usr/local/etc/php-fpm.conf
fi

if [ -z ${MYSQL_DB_PASSWORD+foobar} ];
then
    echo "MYSQL_DB_PASSWORD_ENV_VAR_IS_EMPTY"
else
echo "env[MYSQL_DB_PASSWORD] = $MYSQL_DB_PASSWORD;" >>  /usr/local/etc/php-fpm.conf
fi

if [ -z ${MYSQL_DB_NAME+foobar} ];
then
    echo "MYSQL_DB_NAME_ENV_VAR_IS_EMPTY"
else
echo "env[MYSQL_DB_NAME] = $MYSQL_DB_NAME;" >>  /usr/local/etc/php-fpm.conf
fi
