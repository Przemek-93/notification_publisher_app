DE=docker exec -it -u www-data php-notification-publisher-app
SERVICE_ID=$(shell docker compose ps -q php)

build:
	docker compose build --no-cache

composer:
	docker compose exec php composer install

up:
	docker compose up -d

stop:
	docker compose stop

bash:
	docker compose exec php bash

xon:
	@docker exec -i $(SERVICE_ID) bash -c '[ -f /usr/local/etc/php/disabled/docker-php-ext-xdebug.ini ] && cd /usr/local/etc/php/ && mv disabled/docker-php-ext-xdebug.ini conf.d/ && \
		echo "Xdebug enabled successfully" || echo "Xdebug already enabled"'

xoff:
	@docker exec -i $(SERVICE_ID) bash -c '[ -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ] && cd /usr/local/etc/php/ && mkdir -p disabled/ && mv conf.d/docker-php-ext-xdebug.ini disabled/ && \
		echo "Xdebug disabled successfully" || echo "Xdebug already disabled"'

fix:
	docker compose exec php ./vendor/bin/php-cs-fixer fix --allow-risky=yes

analyse:
	docker compose exec php ./vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --verbose
	docker compose exec php ./vendor/bin/psalm --no-cache