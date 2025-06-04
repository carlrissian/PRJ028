#!/bin/bash
DOCKER_APP = app
DOCKER_NGINX = webserver
UID = $(shell id -u)
PATH_MODULE = RecordGo/ERP/Shared

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

run: ## Start the containers
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose down

restart: ## Restart the containers
	U_ID=${UID} docker-compose down && U_ID=${UID} docker-compose up -d

build: ## Rebuilds all the containers
	U_ID=${UID} docker-compose build

ssh-app: ## ssh's into the be container
	U_ID=${UID} docker-compose exec ${DOCKER_APP} bash

log-app: ## log app
	U_ID=${UID} docker-compose logs -f -t ${DOCKER_APP}

ps: ## view docker processes
	U_ID=${UID} docker ps

composer-install: ## Install composer dependencies
	U_ID=${UID} docker-compose exec ${DOCKER_APP} composer install

push-module: ## push submodule
	U_ID=${UID} cd ${PATH_MODULE} && git checkout master && git pull origin master  && git add .  && git commit  && git push origin master

update-module: ## update module
	U_ID=${UID} git submodule update --remote

init-module: ## pull module and init
	U_ID=${UID} git submodule update --init

ssh-nginx: ## ssh`s into the be container nginx
	U_ID=${UID} docker-compose exec ${DOCKER_NGINX} sh

test-open: ## test cypress navigation
	U_ID=${UID} yarn test:open

test-run: ## test cypress navigation
	U_ID=${UID} yarn test:run

test-unit: ## test backend
	U_ID=${UID} docker-compose exec ${DOCKER_APP} php bin/phpunit

services: ## debug:autowiring
	U_ID=${UID} docker-compose exec ${DOCKER_APP} php bin/console debug:autowiring

init-project: ## init-project
	U_ID=${UID} git submodule update --init
	U_ID=${UID} docker-compose up -d --build --force && docker-compose exec ${DOCKER_APP} composer install
	U_ID=${UID} docker-compose exec ${DOCKER_APP} yarn install && yarn dev
	U_ID=${UID} docker-compose exec ${DOCKER_APP} php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json

generate-routing: ## Generate routing json
	U_ID=${UID} docker-compose exec ${DOCKER_APP} php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json

yarn-d: ## Yarn en dev
	U_ID=${UID} docker-compose exec ${DOCKER_APP} yarn dev

yarn-w: ## Yarn en listener
	U_ID=${UID} docker-compose exec ${DOCKER_APP} yarn watch

yarn-p: ## Yarn en production
	U_ID=${UID} docker-compose exec ${DOCKER_APP} yarn build

run-mac: ## Start mac
	U_ID=${UID} docker-sync-stack start

run-mac-clean: ## Clean mac
	U_ID=${UID} docker-sync clean

.PHONY: run stop restart build ssh-app log-app ps composer-install push-module update-module init-module ssh-nginx test-open test-run test-unit init-project generate-routing run-mac services yarn-d yarn-w
