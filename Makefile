MAKEFLAGS += --warn-undefined-variables --always-make
.DEFAULT_GOAL := _

PHP_VERSION_MAJOR=$(shell cat composer.json | jq -r '.require.php' | sed 's/\^//; s/\..*//')
DEV_IMAGE=etriasnl/dev-php-fpm
DEV_IMAGE_VERSION=$(shell curl -sS "https://hub.docker.com/v2/repositories/${DEV_IMAGE}/tags/?page_size=1&page=1&name=${PHP_VERSION_MAJOR}.&ordering=last_updated" | jq -r '.results[0].name')
DEV_IMAGE_TAG=${DEV_IMAGE}:${DEV_IMAGE_VERSION}

exec_docker=docker run $(shell [ "$$CI" = true ] && echo "-t" || echo "-it") -e CI -e 'COMPOSER_HOME=/tmp/composer' -u "$(shell id -u):$(shell id -g)" --rm -v "$(shell pwd):/app" -w /app
exec_app_docker=${exec_docker} ${DEV_IMAGE_TAG}

composer-normalize:
	${exec_app_docker} sh -c "composer update && composer bump && composer --working-dir=/usr/local/etc/tools normalize /app/composer.json"
lint:
	${exec_app_docker} sh -c "phplint --no-progress --no-cache --warning src"
