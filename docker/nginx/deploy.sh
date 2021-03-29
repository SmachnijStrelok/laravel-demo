#!/usr/bin/env bash

ln -s /etc/nginx/nginx_http.conf /etc/nginx/nginx.conf

sed -i -- "s/\${SITE_NAME}/${SITE_NAME}/" /etc/nginx/nginx.conf

rm -rf /app/public/storage
cd /app/public
ln -s /app/storage/app/public/ pstorage
