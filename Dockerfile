# ── base ──────────────────────────────────────────────────────────────────────
FROM php:8.2-apache

# ── extensões PHP necessárias ─────────────────────────────────────────────────
RUN apt-get update && apt-get install -y \
        libpq-dev \
        zip \
        unzip \
        git \
        curl \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ── Habilita mod_rewrite e configura o Apache para o front controller ─────────
RUN a2enmod rewrite \
    && printf '%s\n' \
       '<VirtualHost *:80>' \
       '    DocumentRoot /var/www/html/public' \
       '    DirectoryIndex index.php index.html' \
       '    <Directory /var/www/html/public>' \
       '        Options Indexes FollowSymLinks' \
       '        AllowOverride All' \
       '        Require all granted' \
       '    </Directory>' \
       '</VirtualHost>' \
       > /etc/apache2/sites-available/000-default.conf
# ── Composer ──────────────────────────────────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ── Copia projeto ─────────────────────────────────────────────────────────────
WORKDIR /var/www/html
COPY . .

# ── Instala dependências PHP ──────────────────────────────────────────────────
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ── Permissões ────────────────────────────────────────────────────────────────
RUN mkdir -p uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/uploads

EXPOSE 80

