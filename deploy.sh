#!/bin/bash

apt-get update --fix-missing;

apt-get install -y apt-transport-https ca-certificates curl gnupg2 software-properties-common git;
curl -fsSL https://download.docker.com/linux/$(. /etc/os-release; echo "$ID")/gpg | apt-key add -;
add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/$(. /etc/os-release; echo "$ID") $(lsb_release -cs) stable";
apt-get update && apt-get install -y docker-ce;

curl -L https://github.com/docker/compose/releases/download/1.19.0/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose;
chmod +x /usr/local/bin/docker-compose;

git clone https://gitlab.com/KocTblJlb/iul-box.git;
cd iul-box;
git checkout deploy;

cp ./.env.example .env;
cp ./composer.json docker/php-fpm/;

chmod -R 777 storage/ bootstrap/cache/;

docker-compose build --no-cache;
docker-compose up -d;

PHP_CONTAINER=$(docker ps --filter=name=php-fpm_1 --filter=status=running -q | head -n1);
docker exec -it ${PHP_CONTAINER} /bin/bash -c 'composer install --no-custom-installers --no-scripts --no-plugins --no-autoloader';
docker exec -it ${PHP_CONTAINER} /bin/bash -c 'composer dump-autoload';
docker exec -it ${PHP_CONTAINER} /bin/bash -c 'php artisan migrate';

chmod -R 777 storage/ bootstrap/cache/ ./vendor/;

docker exec -it ${PHP_CONTAINER} /bin/bash -c 'cd /app/scripts; ./fresh-compile.sh;';

chmod -R 777 storage/ bootstrap/cache/ ./vendor/;

rm docker/php-fpm/composer.json;
