# Use a imagem oficial do PHP com FPM
FROM php:8.1-fpm

# Atualize o repositório e instale as dependências necessárias
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath zip

# Defina o diretório de trabalho
WORKDIR /var/www

# Copie os arquivos da aplicação para o diretório de trabalho
COPY . .

# Instale as dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Gere a chave da aplicação
RUN php artisan key:generate

# Exponha a porta 9000 e inicie o PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
