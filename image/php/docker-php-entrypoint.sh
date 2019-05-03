#!/bin/sh
set -e

#mirror
if [ ! -z "${COMPOSER_MIRROR_URL}" ];then
	composer config -g repo.packagist composer ${COMPOSER_MIRROR_URL}
else
	composer config -g --unset repos.packagist
fi
	
# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"
