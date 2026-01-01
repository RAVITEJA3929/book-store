FROM php:8.2-apache
RUN apt-get update && apt-get install -y mariadb-client libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*
COPY . /var/www/html/
COPY init-db.sh /init-db.sh
RUN chmod +x /init-db.sh
EXPOSE 80
CMD ["/init-db.sh"]
