.PHONY: up down sh play tests fmt-check lint guard analyze check

export DOCKER_CLI_HINTS=false

TTY := $(shell [ -t 0 ] || echo -T)
EXEC := docker compose exec $(TTY) app

up:
	@docker compose up -d --build
	@$(EXEC) composer install

down:
	@docker compose down

sh:
	@docker compose exec app sh

start:
	@docker compose exec app php bin/console tennis-game:start

tests:
	@$(EXEC) php vendor/bin/phpunit tests

fix:
	@$(EXEC) php vendor/bin/mago fmt
	@$(EXEC) php vendor/bin/mago lint --fix
	@$(EXEC) php vendor/bin/mago analyze --fix --potentially-unsafe --format-after-fix

fmt-check:
	@$(EXEC) php vendor/bin/mago fmt --check

lint:
	@$(EXEC) php vendor/bin/mago lint

guard:
	@$(EXEC) php vendor/bin/mago guard

analyze:
	@$(EXEC) php vendor/bin/mago analyze

check:
	@fail=0; \
	$(MAKE) --no-print-directory fmt-check || fail=1; \
	$(MAKE) --no-print-directory lint      || fail=1; \
	$(MAKE) --no-print-directory guard     || fail=1; \
	$(MAKE) --no-print-directory analyze   || fail=1; \
	exit $$fail
