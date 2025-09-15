SHELL := /bin/sh
COMPOSE ?= docker compose
ENVFILE ?= .env

.PHONY: build up down restart logs ps shell web-shell db-shell migrate seed smoke clean dev

build:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) build

up:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) up -d

down:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) down

restart:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) restart

logs:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) logs -f --tail=200

ps:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) ps

shell:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) exec app sh

web-shell:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) exec web sh

db-shell:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) exec db bash -lc "mariadb -uroot -p$$MYSQL_ROOT_PASSWORD $$MYSQL_DATABASE"

migrate:
	@echo "Initial schema is auto-applied from u170679010_fpptu.sql on first run."

seed:
	@echo "Add seed SQLs under docker/mysql/init and mount them if needed."

smoke:
	@echo "Waiting for service..."; \
	for i in $$(seq 1 30); do \
	  if curl -fsS http://localhost:$$(grep -E '^APP_PORT=' $(ENVFILE) | cut -d= -f2)/health >/dev/null; then \
	    echo "OK"; exit 0; \
	  fi; \
	  sleep 1; \
	done; \
	echo "Smoke test failed"; exit 1

prod-build:
	$(COMPOSE) -f docker-compose.prod.yml --env-file $(ENVFILE) build

prod-up:
	$(COMPOSE) -f docker-compose.prod.yml --env-file $(ENVFILE) up -d

prod-down:
	$(COMPOSE) -f docker-compose.prod.yml --env-file $(ENVFILE) down

dev:
	$(COMPOSE) -f docker-compose.yml --env-file $(ENVFILE) up -d --build
