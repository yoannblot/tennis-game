.PHONY: up down sh play

up:
	docker compose up -d --build
	docker compose exec app composer install

down:
	docker compose down

sh:
	docker compose exec app sh

start:
	@docker compose exec app php bin/application.php tennis-game:start
