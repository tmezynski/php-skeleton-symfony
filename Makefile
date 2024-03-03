DC = USER_ID=$(shell id -u) GROUP_ID=$(shell id -g) docker-compose -f ./docker/docker-compose.yml

########################################################################################################################
################################################## DEV TOOLS ###########################################################
########################################################################################################################
.PHONY: create
create: images init

.PHONY: images
images:
	@$(DC) build

.PHONY: images-force
images-force:
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
	@$(DC) exec redis redis-cli flushall
	@$(DC) exec php composer install
	@$(MAKE) migrations

.PHONY: console
console:
	@$(DC) exec php sh

################################################### DATABASE ###########################################################
.PHONY: migrations
migrations:
	@$(DC) exec php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
	@$(DC) exec -e APP_ENV=test php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

.PHONY: create-migration
create-migration:
	@$(DC) exec php bin/console doctrine:migrations:generate --no-interaction

.PHONY: clear-cache
clear-cache:
	@$(DC) exec php rm -rf var/cache

########################################################################################################################
#################################################### TESTS #############################################################
########################################################################################################################
.PHONY: test
test: static unit integration acceptance

#################################################### STATIC ############################################################
.PHONY: static
static: stan code-sniffer mess-detector magic-numbers deptrac

.PHONY: stan
stan:
	@$(DC) exec -e APP_ENV=test php ./script/stan.sh

.PHONY: code-sniffer
code-sniffer:
	@$(DC) exec -e APP_ENV=test php ./script/code-sniffer.sh

.PHONY: code-sniffer-fix
code-sniffer-fix:
	@$(DC) exec -e APP_ENV=test php ./script/code-sniffer-fix.sh

.PHONY: mess-detector
mess-detector:
	@$(DC) exec -e APP_ENV=test php ./script/mess-detector.sh

.PHONY: magic-numbers
magic-numbers:
	@$(DC) exec -e APP_ENV=test php ./script/magic-number-detection.sh

.PHONY: deptrac
deptrac:
	@$(DC) exec -e APP_ENV=test php ./script/deptrac.sh

##################################################### UNIT #############################################################
.PHONY: unit
unit:
	@$(DC) exec -e APP_ENV=test php ./script/unit.sh

################################################## INTEGRATION #########################################################
.PHONY: integration
integration:
	@$(DC) exec -e APP_ENV=test php ./script/integration.sh

################################################### ACCEPTANCE #########################################################
.PHONY: acceptance
acceptance:
	@$(DC) exec -e APP_ENV=test php ./script/behat.sh

#################################################### MUTATION ##########################################################
.PHONY: infection
infection:
	@$(DC) exec -e APP_ENV=test php ./script/infection.sh

#################################################### COVERAGE ##########################################################
.PHONY: coverage
coverage:
	@$(DC) exec -e APP_ENV=test php ./script/coverage.sh
