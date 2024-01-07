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

.PHONY: start
start:
	@$(DC) up -d

.PHONY: stop
stop:
	@$(DC) down

.PHONY: destroy
destroy:
	@$(DC) down -v

.PHONY: init
init: start
	$(DC) exec php composer install

.PHONY: console
console:
	@$(DC) exec php sh


new-migration:
	$(DC) exec php ./bin/console doctrine:migration:generate

.PHONY: migrations
migrations:
	$(DC) exec php ./bin/console doctrine:migration:migrate

########################################################################################################################
#################################################### TESTS #############################################################
########################################################################################################################
.PHONY: test
test: static unit integration acceptance

.PHONY: static
static: stan code-sniffer mess-detector magic-numbers

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

.PHONY: unit
unit:
	@$(DC) exec php ./script/unit.sh

.PHONY: integration
integration:
	@$(DC) exec php ./script/integration.sh

.PHONY: acceptance
acceptance:
	@$(DC) exec php ./script/acceptance.sh

.PHONY: infection
infection:
	@$(DC) exec php ./script/infection.sh
