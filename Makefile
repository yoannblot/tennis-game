.PHONY: up down sh play tests

up:
	@docker compose up -d --build
	@docker compose exec app composer install

down:
	@docker compose down

sh:
	@docker compose exec app sh

start:
	@docker compose exec app php bin/console tennis-game:start

tests:
	@docker compose exec app php vendor/bin/phpunit tests
