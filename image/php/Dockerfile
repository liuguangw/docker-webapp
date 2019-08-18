ARG PHP_IMAGE_VERSION
FROM php:${PHP_IMAGE_VERSION}

ARG DEBIAN_APT_MIRROR_URL
ARG COMPOSER_DOWNLOAD_MIRROR_URL
#entrypoint
COPY docker-php-entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod a+x /usr/local/bin/docker-php-entrypoint \
	&& if [ ! -z "${DEBIAN_APT_MIRROR_URL}" ];then \
		cp /etc/apt/sources.list /etc/apt/sources.list.bak; \
		sed  -i "s#deb.debian.org/debian#${DEBIAN_APT_MIRROR_URL}#g"  /etc/apt/sources.list; \
	fi \
	&& apt-get update && apt-get install -y --no-install-recommends \
	procps \
	git \
	unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
	#redis
	&& pecl install redis \
	&& docker-php-ext-enable redis \
	#mysql
	&& docker-php-ext-install mysqli pdo_mysql \
	#gd
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
	#composer
	&& if [ -z "${COMPOSER_DOWNLOAD_MIRROR_URL}" ];then \
		COMPOSER_DOWNLOAD_MIRROR_URL="https://getcomposer.org/composer.phar"; \
	fi \
	&& curl -o /usr/local/bin/composer ${COMPOSER_DOWNLOAD_MIRROR_URL} \
	&& chmod a+x /usr/local/bin/composer
