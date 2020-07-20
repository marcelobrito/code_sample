FROM php:7.4-fpm
RUN apt-get update && apt-get install -y git libonig-dev libzip-dev zlib1g-dev npm && apt-get clean
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer 
RUN docker-php-ext-install -j$(nproc) zip mbstring pdo_mysql
RUN npm install -g npm@latest
RUN usermod -u 1000 www-data
