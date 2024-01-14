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
	#@make migrations - enable after adding first migration

.PHONY: console
console:
	@$(DC) exec php sh

################################################### DATABASE ###########################################################
.PHONY: migrations
migrations:
	@$(DC) exec php bin/console doctrine:migrations:migrate --no-interaction

.PHONY: create-migration
create-migration:
	@$(DC) exec php bin/console doctrine:migrations:generate --no-interaction

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
	@$(DC) exec php ./script/stan.sh

.PHONY: code-sniffer
code-sniffer:
	@$(DC) exec php ./script/code-sniffer.sh

.PHONY: code-sniffer-fix
code-sniffer-fix:
	@$(DC) exec php ./script/code-sniffer-fix.sh

.PHONY: mess-detector
mess-detector:
	@$(DC) exec php ./script/mess-detector.sh

.PHONY: magic-numbers
magic-numbers:
	@$(DC) exec php ./script/magic-number-detection.sh

.PHONY: deptrac
deptrac:
	@$(DC) exec php ./script/deptrac.sh

##################################################### UNIT #############################################################
.PHONY: unit
unit:
	@$(DC) exec php ./script/unit.sh

################################################## INTEGRATION #########################################################
.PHONY: integration
integration:
	@$(DC) exec php ./script/integration.sh

################################################### ACCEPTANCE #########################################################
.PHONY: acceptance
acceptance:
	@$(DC) exec php ./script/acceptance.sh

#################################################### MUTATION ##########################################################
.PHONY: infection
infection:
	@$(DC) exec php ./script/infection.sh

#################################################### COVERAGE ##########################################################
.PHONY: coverage
coverage:
	@$(DC) exec php ./script/coverage.sh
