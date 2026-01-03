DC = $(if $(shell which docker-compose),USER_ID=$(shell id -u) docker-compose,USER_ID=$(shell id -u) docker compose)
include .env
export

########################################################################################################################
################################################## DEV TOOLS ###########################################################
########################################################################################################################
.PHONY: create
create: build composer db db-test clear-logs

.PHONY: build
build:
	@$(DC) build

.PHONY: build-force
build-force:
	@$(DC) build --no-cache

.PHONY: up
up:
	@$(DC) up -d

.PHONY: down
down:
	@$(DC) down --remove-orphans

.PHONY: logs
logs:
	@$(DC) logs -f

.PHONY: destroy
destroy:
	@$(DC) down -v

.PHONY: composer
composer: up
	@$(DC) exec php composer install

.PHONY: db
db:
	@$(DC) exec php composer database:init

.PHONY: db-test
db-test:
	@$(DC) exec php composer test:database:init

.PHONY: sh
sh:
	@$(DC) exec php sh

.PHONY: cc
cc:
	@$(DC) exec php sh -c 'rm -rf /app/var/cache'
	@$(DC) exec php composer cache:clear
	@$(DC) exec php composer dump-autoload

.PHONY: clear-logs
clear-logs:
	@$(DC) exec php sh -c 'rm -rf /app/var/log'

.PHONY: create-migration
create-migration:
	@$(DC) exec php composer database:migration:create

########################################################################################################################
#################################################### TESTS #############################################################
########################################################################################################################
.PHONY: test
test: test-static test-unit test-integration test-acceptance

################################################### STATIC #############################################################
.PHONY: test-static
test-static: test-csfixer test-phpstan test-deptrac test-md

.PHONY: fix-static
fix-static:
	@$(DC) exec php composer test:csfixer:fix

.PHONY: test-phpstan
test-phpstan:
	@$(DC) exec php composer test:phpstan

.PHONY: test-csfixer
test-csfixer:
	@$(DC) exec php composer test:csfixer

.PHONY: test-deptrac
test-deptrac:
	@$(DC) exec php composer test:deptrac

.PHONY: test-md
test-md:
	@$(DC) exec php composer test:md

##################################################### UNIT #############################################################
.PHONY: test-unit
test-unit:
	@$(DC) exec php composer test:unit

################################################## INTEGRATION #########################################################
.PHONY: test-integration
test-integration:
	@$(DC) exec php composer test:integration

################################################## ACCEPTANCE ##########################################################
.PHONY: test-acceptance
test-acceptance:
	@$(DC) exec php composer test:acceptance

################################################### MUTATION ###########################################################
.PHONY: test-mutation
test-mutation:
	@$(DC) exec php composer test:mutation

################################################### COVERAGE ###########################################################
.PHONY: test-coverage
test-coverage:
	@$(DC) exec php composer test:coverage

.PHONY: test-path-coverage
test-path-coverage:
	@$(DC) exec php composer test:coverage:path
