FROM nginx:latest

USER root
RUN apt-get update && \
    apt-get install -y \
    apt-transport-https \
    ca-certificates \
    certbot


EXPOSE 80 443

ARG USE_HTTPS
ARG SITE_NAME=_
ENV SITE_NAME ${SITE_NAME}

RUN rm -rf /app/public/storage || echo 'public storage not found!'
WORKDIR /app/public
RUN ln -s /app/storage/app/public/ storage || true
WORKDIR /

RUN rm /etc/nginx/nginx.conf
COPY ./nginx_http.conf /etc/nginx/nginx_http.conf
COPY ./deploy.sh /deploy.sh
RUN /bin/bash /deploy.sh

ENTRYPOINT ["nginx", "-g", "daemon off;"]
