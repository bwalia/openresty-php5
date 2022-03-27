#!/usr/bin/bash

# Quit on error.
set -e
# Treat undefined variables as errors.
set -u

function main {

# Create dir for pid file.
mkdir -p /var/php/
chown www-data:root /var/php/
chmod +x /var/php/
chmod 755 -R /var/php/

# Create dir for php unix sockets.
mkdir -p /var/run/php-fpm/
chown www-data:root /var/run/php-fpm/
chmod +x /var/run/php-fpm/
chmod 755 -R /var/run/php-fpm/

mkdir -p /var/log/nginx/
chown www-data:root /var/log/nginx/
chmod +x /var/log/nginx/
chmod 755 -R /var/log/nginx/

mkdir -p /var/nginx/
chown www-data:root /var/nginx/
chmod +x /var/nginx/
chmod 755 -R /var/nginx/

mkdir -p /var/www/html
chown -R www-data:www-data /var/www/html 
chmod -R 755 /var/www/html 

# systemctl daemon-reload
# systemctl enable php-fpm-5.service
# systemctl start php-fpm-5.service
# systemctl status php-fpm-5.service
# instead of 'x' we used 'foobar'
# but 'x' seems like a good practice 

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

}

main "$@"
