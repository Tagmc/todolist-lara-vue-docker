FROM php:8.2-fpm

# Cài các extension và dependency cần thiết
RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libssl-dev tzdata \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Cài composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set thư mục làm việc
WORKDIR /var/www

# Copy source vào container
COPY . .

# Cài đặt package Laravel
RUN composer install

# Mở port 8000 để chạy artisan serve
EXPOSE 8000

# Chạy Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
