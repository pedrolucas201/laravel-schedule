# Use uma imagem oficial do PHP com FPM
FROM php:8.1-fpm

# Instale as dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl

# Instale extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Configure o diretório de trabalho
WORKDIR /var/www

# Copie os arquivos da aplicação para dentro do container
COPY . /var/www

# Instale as dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Gere a chave da aplicação (se não existir)
RUN php artisan key:generate --force

# Exponha a porta padrão do PHP-FPM
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
