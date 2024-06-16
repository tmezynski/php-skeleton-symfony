DC = USER_ID=$(shell id -u) GROUP_ID=$(shell id -g) docker-compose -f ./compose.yaml

########################################################################################################################
################################################## DEV TOOLS ###########################################################
########################################################################################################################
.PHONY: create
create: build init

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
	@$(DC) down

.PHONY: destroy
destroy:
	@$(DC) down -v

.PHONY: init
init: up
	@$(DC) exec php composer install
	@$(MAKE) migrations-test

.PHONY: sh
sh:
	@$(DC) exec php sh

################################################### DATABASE ###########################################################
.PHONY: migrations
migrations:
	@$(DC) exec php composer migrations:migrate

.PHONY: migrations-test
migrations-test:
	@$(DC) exec php composer migrations:migrate:test

.PHONY: cc
cc:
	@$(DC) exec php composer cache:clear
	@rm -rf var/cache/*

########################################################################################################################
#################################################### TESTS #############################################################
########################################################################################################################
.PHONY: test
test: test-static test-unit test-integration test-behat

#################################################### STATIC ############################################################
.PHONY: test-static
test-static: test-phpstan test-csfixer test-deptrac

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

##################################################### UNIT #############################################################
.PHONY: test-unit
test-unit:
	@$(DC) exec php composer test:unit

################################################## INTEGRATION #########################################################
.PHONY: test-integration
test-integration:
	@$(DC) exec php composer test:integration

##################################################### BEHAT ############################################################
.PHONY: test-behat
test-behat:
	@$(DC) exec php composer test:behat

#################################################### MUTATION ##########################################################
.PHONY: test-mutation
test-mutation:
	@$(DC) exec php composer test:mutation

#################################################### COVERAGE ##########################################################
.PHONY: test-coverage
test-coverage:
	@$(DC) exec php composer test:coverage
