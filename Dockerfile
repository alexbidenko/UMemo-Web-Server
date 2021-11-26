FROM php:8-apache
WORKDIR /var/www/html

RUN docker-php-ext-install mysqli
RUN chmod 777 back_images

COPY . .

EXPOSE 80
