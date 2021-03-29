#!/bin/bash

apt-get update --fix-missing;

apt-get install -y apt-transport-https ca-certificates curl gnupg2 software-properties-common git;
curl -fsSL https://download.docker.com/linux/$(. /etc/os-release; echo "$ID")/gpg | apt-key add -;
add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/$(. /etc/os-release; echo "$ID") $(lsb_release -cs) stable";
apt-get update && apt-get install -y docker-ce;

curl -L https://github.com/docker/compose/releases/download/1.19.0/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose;
chmod +x /usr/local/bin/docker-compose;

docker-compose up -d;
sleep 7;

PHP_CONTAINER=$(docker ps --filter=name=php-fpm_1 --filter=status=running -q | head -n1);
docker exec -it ${PHP_CONTAINER} /bin/bash -c 'php artisan migrate';

chmod -R 777 storage/;
