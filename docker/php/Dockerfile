FROM public.ecr.aws/docker/library/php:8.2.11-apache as base

# Only the minimum required packages are installed
RUN \
apt-get upgrade \
&& apt-get update && apt-get install -y \
    curl \
    unzip \
    libzip-dev \
&& apt-get clean \
&& a2enmod remoteip \
&& a2enmod rewrite \
&& rm -rf /var/lib/apt/lists/* \
&& docker-php-ext-install -j$(nproc) \
    zip \
&& docker-php-source delete

# install composer
COPY --from=public.ecr.aws/docker/library/composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

COPY  ./docker/php/000-default.conf /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www/laravel

FROM base as local

RUN groupadd -g 1000 user && \
    useradd -m -s /bin/bash -u 1000 -g 1000 user
USER user

