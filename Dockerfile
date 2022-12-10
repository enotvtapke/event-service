FROM enotvtapke/personal:nginx-fpm
RUN apk add php8-pdo php8-pdo php8-pgsql php8-pdo_pgsql php8-tokenizer php8-ctype
RUN apk add php8-dom php8-xmlwriter php8-xml php8-simplexml
RUN apk add liquibase --repository=http://dl-cdn.alpinelinux.org/alpine/edge/testing/
WORKDIR /var/www/php
COPY . .
RUN composer update
RUN composer install --no-dev