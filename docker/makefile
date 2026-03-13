# ─── PerpusPHP Docker Makefile ────────────────────────────────────────────
.PHONY: help up down build restart logs shell mysql

help: ## Tampilkan daftar perintah
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'

up: ## Jalankan semua container
	docker compose up -d

down: ## Hentikan semua container
	docker compose down

build: ## Build ulang image PHP
	docker compose build --no-cache

restart: ## Restart semua container
	docker compose restart

logs: ## Lihat logs semua container
	docker compose logs -f

logs-nginx: ## Lihat logs Nginx
	docker compose logs -f nginx

logs-php: ## Lihat logs PHP
	docker compose logs -f php

shell: ## Masuk ke container PHP
	docker compose exec php sh

mysql-shell: ## Masuk ke MySQL CLI
	docker compose exec mysql mysql -u perpus_user -pperpus_pass perpus_db

import-sql: ## Import file SQL: make import-sql FILE=dump.sql
	docker compose exec -T mysql mysql -u perpus_user -pperpus_pass perpus_db < $(FILE)

status: ## Cek status container
	docker compose ps