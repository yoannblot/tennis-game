.PHONY: up down sh play tests

export DOCKER_CLI_HINTS=false

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

fix:
	@docker compose exec app php vendor/bin/mago fmt
	@docker compose exec app php vendor/bin/mago lint --fix
	@docker compose exec app php vendor/bin/mago analyze --fix --potentially-unsafe --format-after-fix

check:
	@docker compose exec app php vendor/bin/mago fmt --check
	@docker compose exec app php vendor/bin/mago lint
	@docker compose exec app php vendor/bin/mago guard
	@docker compose exec app php vendor/bin/mago analyze
