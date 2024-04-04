FROM php:8.1-fpm

# 必要なツールをインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip

# PHPの拡張機能をインストール
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install fileinfo

WORKDIR /var/www/html

# Composerのインストール
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Laravelのソースコードをコピー
COPY . .

RUN composer install
