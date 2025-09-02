FROM php:8.2-apache

# ติดตั้ง Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ติดตั้ง extension ที่ต้องใช้ เช่น intl, pdo_mysql
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install intl pdo_mysql mysqli zip

# คัดลอกไฟล์โปรเจกต์ทั้งหมดเข้า container
COPY . /var/www/html

# ติดตั้ง dependencies ของโปรเจกต์
WORKDIR /var/www/html
    
# เปิดใช้งาน Apache mod_rewrite (จำเป็นสำหรับ CI4)
RUN a2enmod rewrite

# กำหนด DocumentRoot ไปที่ public (ของ CodeIgniter4)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# เปลี่ยน Apache config ให้รองรับ public/
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf