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
	@echo "Adicionando Pest para testes... 🧪"
	@echo "======================================="
	@docker compose exec app composer require pestphp/pest --dev --with-all-dependencies
	@docker compose exec app mkdir -p ./vendor/pestphp/pest/.temp
	@docker compose exec app chmod -R 777 ./vendor/pestphp/pest/.temp
