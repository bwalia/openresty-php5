#!/bin/bash

# Quit on error.
set -e
# Treat undefined variables as errors.
set -u

# Create dir for pid file.
mkdir -p /var/php/
chown www-data:root /var/php/
chmod +x /var/php/
chmod 755 -R /var/php/

mkdir -p /etc/php/5.6/
chown www-data:root /etc/php/5.6/
chmod +x /etc/php/5.6/
chmod 755 -R /etc/php/5.6/

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
