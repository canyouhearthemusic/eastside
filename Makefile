.PHONY: up key-generate install dump-autoload migrate optimize

up:
	docker compose up -d

key-generate:
	docker compose run --rm artisan key:generate

install:
	docker compose run --rm composer install

dump-autoload:
	docker compose run --rm composer dump-autoload

migrate:
	docker compose run --rm artisan migrate --seed

optimize:
	docker compose run --rm artisan optimize

all: up key-generate install dump-autoload migrate optimize