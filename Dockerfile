FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
        curl ca-certificates git unzip \
        libpq-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_pgsql pgsql zip gd mbstring exif pcntl bcmath \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP deps first so this layer caches independently of app code changes.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --no-progress

# Install JS deps.
COPY package.json package-lock.json ./
RUN npm ci

# Now bring in the app and finish setup (autoloader, package discovery, asset build).
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm run build \
    && rm -rf node_modules \
    && chmod +x docker/start.sh

EXPOSE 10000
ENTRYPOINT ["docker/start.sh"]
