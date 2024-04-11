FROM php:8.1-fpm

# 必要なツールをインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    gd \
    zip

# PHPの拡張機能をインストール
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install fileinfo

# Laravelのソースコードをコピー
WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R root:www-data . && chmod -R 777 storage

# Composerのインストール
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer install
