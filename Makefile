USER := $(shell whoami)
UID := $(shell id -u)

start: build up permissions setup

build:
	docker compose build --build-arg USER=$(USER) --build-arg UID=$(UID)

up:
	docker compose up -d

permissions:
	sudo chmod -R 777 storage

setup:
	cp .env.example .env
	docker exec -it app-payments composer start-app

stop:
	docker compose down

logs:
	docker compose logs -f

test:
	docker exec app-payments php artisan test