# Gunakan image PHP + Apache
FROM php:8.1-apache

# Copy semua file project ke dalam folder web server di container
COPY . /var/www/html/

# Install ekstensi tambahan kalau dibutuhkan (contoh: mysqli)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Buka port 80 (web server)
EXPOSE 80
