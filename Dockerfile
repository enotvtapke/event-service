FROM php-nginx
RUN apk add php8-pdo php8-pdo php8-pgsql php8-pdo_pgsql php8-tokenizer php8-ctype
RUN apk add php8-dom php8-xmlwriter php8-xml php8-simplexml
RUN apk add liquibase --repository=http://dl-cdn.alpinelinux.org/alpine/edge/testing/
WORKDIR /var/www/php
COPY . .
RUN composer update
RUN composer install --no-dev
#RUN bash ./db/migrate.sh
#CMD ["/bin/bash", "-c", "bash /var/www/php/db/migrate.sh"]
#RUN apt update
#RUN apt upgrade
#RUN sudo apt install apt-transport-https lsb-release ca-certificates wget -y &&\
#    sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg &&\
#    sudo sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' &&\
#    sudo apt update

#/bin/bash -c cd /var/www/php && composer install --no-dev