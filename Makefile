DOCKER_COMPOSE := $(shell command -v docker compose 2> /dev/null)

ifndef DOCKER_COMPOSE
$(error "docker-compose is not installed or not in your PATH")
endif

setup: 
	@echo "Preparando ambiente docker... 🏗️"
	@echo "Iniciando containers... 🚀"
	@echo "======================================="
	@docker compose up -d
	@echo "Instalando dependências... 📦"
	@echo "======================================="
	@docker compose exec app composer install --no-interaction