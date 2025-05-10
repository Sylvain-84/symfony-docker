# Nom du conteneur PHP (ajuste-le si le tien est différent)
PHP_CONTAINER = symfony-docker-php-1

# Commande Symfony
SYMFONY = docker exec -it $(PHP_CONTAINER) php bin/console
COMPOSER = docker exec -it $(PHP_CONTAINER) composer
PHPUNIT = docker exec --tty $(PHP_CONTAINER) bin/phpunit
PHPSTAN = docker exec -it $(PHP_CONTAINER) vendor/bin/phpstan analyse --memory-limit=512M
PHPCS = docker exec -it $(PHP_CONTAINER) vendor/bin/phpcs
PHPCSFIXER = docker exec -it $(PHP_CONTAINER) vendor/bin/php-cs-fixer fix --dry-run --diff

# Par défaut, affiche l'aide
help:
	@echo "Usage:"
	@echo "  make console CMD='your:symfony:command'"
	@echo "  make new-migration"
	@echo "  make migrate"
	@echo "  make fixtures"
	@echo "  make cache-clear"

# Composer avec argument libre
composer:
	$(COMPOSER) $(CMD)

# Exécute une commande Symfony passée via CMD
console:
	$(SYMFONY) $(CMD)

# Exemples d’alias utiles
new-migration:
	$(SYMFONY) make:migration --no-interaction

# Exemples d’alias utiles
migrate:
	$(SYMFONY) doctrine:migrations:migrate --no-interaction
	$(SYMFONY) doctrine:migrations:migrate --env=test --no-interaction

# Exemples d’alias utiles
test-migrate:

fixtures:
	$(SYMFONY) doctrine:fixtures:load --no-interaction

fixtures-test:
	$(SYMFONY) doctrine:fixtures:load --env=test --no-interaction

cache-clear:
	$(SYMFONY) cache:clear

phpunit:
	$(PHPUNIT) $(ARGS)

# Code Quality
phpstan:
	$(PHPSTAN)

phpcs:
	$(PHPCS)

php-cs-fixer:
	$(PHPCSFIXER)

php-cs-fixer-fix:
	docker exec -it $(PHP_CONTAINER) vendor/bin/php-cs-fixer fix

# 🚦 Tout-en-un : Qualité de code
quality:
	@echo "➡️  PHP-CS-Fixer (apply fix)"
	@docker exec -it $(PHP_CONTAINER) \
	      vendor/bin/php-cs-fixer fix
	@echo "➡️  PHPStan"
	@$(PHPSTAN)
	@echo "➡️  PHP_CodeSniffer"
	@$(PHPCS)
	@echo "➡️  PHP-CS-Fixer (dry-run)"
	@$(PHPCSFIXER)

# reset database for dev and test
reset-db:
	# --- base de développement ---
	$(SYMFONY) doctrine:database:drop    --force --if-exists
	$(SYMFONY) doctrine:database:create  --no-interaction
	$(SYMFONY) doctrine:migrations:migrate --no-interaction
	$(SYMFONY) doctrine:fixtures:load    --no-interaction

	# --- base de tests ---
	$(SYMFONY) doctrine:database:drop    --env=test --force --if-exists
	$(SYMFONY) doctrine:database:create  --env=test --no-interaction
	$(SYMFONY) doctrine:migrations:migrate --env=test --no-interaction
	$(SYMFONY) doctrine:fixtures:load    --env=test --no-interaction
