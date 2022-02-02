#=======================#
# composer já instalado #
#=======================#
FROM composer:latest AS composer

#==============================#
# baixar dependências composer #
#==============================#
FROM ubuntu/apache2:2.4-20.04_beta

RUN apt-get update

RUN apt-get install -y software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update

RUN apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libssl-dev \
    pkg-config \
    zip \
    curl \
    unzip \
    git \
    ssh-tools \
    supervisor

RUN apt-get install -y \
    php5.6 \
    php5.6-mbstring \
    php5.6-xdebug \
    php5.6-xml

RUN apt-get install -y \
    php7.2 \
    php7.2-mbstring \
    php7.2-xdebug \
    php7.2-xml

RUN apt-get install -y \
    libapache2-mod-php5.6 \
    libapache2-mod-php7.2

RUN a2enmod php5.6

# instalar composer a partir do outro container
COPY --from=composer /usr/bin/composer /usr/bin/composer

# copiando configs do apache
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/apache/ports.conf /etc/apache2/ports.conf
COPY docker/apache/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf

# copiando config do supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN usermod -a -G sudo www-data

RUN chmod -R 775 /var/www/html

# ajustando permissão da pasta para o apache
# e habilitando alguns módulos
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && a2enmod proxy \
    && a2enmod proxy_http \
    && a2enmod proxy_http2 \
    && a2enmod ssl \
    && echo "ServerName 127.0.0.1" | tee -a /etc/apache2/apache2.conf

# abrindo porta 80
EXPOSE 80

WORKDIR /var/www/html/

# iniciando supervisor
CMD ["supervisord"]
