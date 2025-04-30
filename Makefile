# Nom du conteneur PHP (ajuste-le si le tien est différent)
PHP_CONTAINER = symfony-docker-php-1

# Commande Symfony
SYMFONY = docker exec -it $(PHP_CONTAINER) php bin/console
COMPOSER = docker exec -it $(PHP_CONTAINER) composer
PHPUNIT = docker exec --tty $(PHP_CONTAINER) bin/phpunit

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

fixtures:
	$(SYMFONY) doctrine:fixtures:load --no-interaction

cache-clear:
	$(SYMFONY) cache:clear

phpunit:
	$(PHPUNIT) $(ARGS)
