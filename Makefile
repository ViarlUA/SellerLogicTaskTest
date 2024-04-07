#!/usr/bin/make

THIS_FILE := $(lastword $(MAKEFILE_LIST))

.PHONY : up-all

.DEFAULT_GOAL := help

help:
	make -pRrq  -f $(THIS_FILE) : 2>/dev/null | awk -v RS= -F: '/^# File/,/^# Finished Make data base/ {if ($$1 !~ "^[#.]") {print $$1}}' | sort | egrep -v -e '^[^[:alnum:]]' -e '^$@$$'
up:
	docker-compose up -d
down:
	docker-compose down
init:
	docker-compose exec app bash -c "composer install"
	docker-compose exec app bash -c "php artisan key:generate"
	docker-compose exec app bash -c "php artisan migrate:fresh"
	docker-compose exec app bash -c "php artisan ide-helper:model -M"
	docker-compose exec app bash -c "composer install --working-dir=tools/php-cs-fixer"
	docker-compose exec app bash -c "composer install --working-dir=tools/phpstan"
	docker-compose exec app bash -c "composer install --working-dir=tools/psalm"


check_code:
	docker-compose exec app bash -c "composer run check_style"
	docker-compose exec app bash -c "composer run psalm"
	docker-compose exec app bash -c "composer run phpstan"
