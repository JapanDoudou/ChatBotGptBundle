HOST_GROUP_ID = $(shell id -g)
HOST_USER = ${USER}
HOST_UID = $(shell id -u)

export HOST_UID
export HOST_USER
export HOST_GROUP_ID

DOCKER_COMPOSE_DEV = docker compose -f docker-compose.yml

help: ## Display available commands
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# =====================================================================
# Install =============================================================
# =====================================================================

install: ## Install docker stack, assets and vendors
	$(DOCKER_COMPOSE_DEV) pull
	$(DOCKER_COMPOSE_DEV) build
	$(MAKE) composer-install
	$(MAKE) grumphp-install

composer-install: ## Install composer vendor and setup assets
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'composer install'
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'rm composer.lock'

grumphp-install: ## Install javascript modules
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php ./vendor/bin/grumphp git:init'

# =====================================================================
# Development =========================================================
# =====================================================================

start: ## Start all the stack (you can access the project on localhost:8080 after that)
	$(DOCKER_COMPOSE_DEV) up -d

stop: ## Stop all the containers that belongs to the project
	$(DOCKER_COMPOSE_DEV) down

connect: ## Connect on a remote bash terminal on the php container
	$(DOCKER_COMPOSE_DEV) exec php bash

log: ## Show logs from php container
	$(DOCKER_COMPOSE_DEV) logs -f php

status: ## Check container status
	$(DOCKER_COMPOSE_DEV) ps

default: help