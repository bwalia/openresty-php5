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

# systemctl daemon-reload
# systemctl enable php-fpm-5.service
# systemctl start php-fpm-5.service
# systemctl status php-fpm-5.service

}

main "$@"
