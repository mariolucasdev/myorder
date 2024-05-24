DOCKER_COMPOSE := $(shell command -v docker compose 2> /dev/null)
ENV_FILE=.env

ifndef DOCKER_COMPOSE
$(error "docker compose is not installed or not in your PATH")
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
	@echo "Connfigurando banco de dados... 🗃️"
	
	@echo "======================================="
	@mkdir -p ./.docker/db/mysql
	@mkdir -p ./storage/cache
	@mkdir -p './tests/Architecture'
	@echo "Permissões para pastas:"
	@echo "	📁 .docker/db/mysql"
	@echo "	📁 storage/cache"
	@echo "	📁 tests/Architecture"
	
	@echo "======================================="
	@echo "⚠️ Será necessário informar a senha do usuário root do MySQL para permissão nas pastas criadas listadas acima."
	@sudo chmod -R 755 ./.docker/db/mysql
	@sudo chmod -R 755 ./storage/cache
	@sudo chmod -R 755 ./tests/Architecture
	@echo "Configurando ambiente... 🛠️"
	
	@echo "======================================="
	@docker compose exec app cp .env.example .env
	
	@echo "======================================="
	@echo "Gerando chave de aplicação... 🔑"
	@echo "Adicionando token ao arquivo .env..."
	@if [ ! -f $(ENV_FILE) ]; then \
		echo "O arquivo .env não existe. Criando..."; \
		touch $(ENV_FILE); \
	fi
	@TOKEN=$$(openssl rand -base64 32); \
	if grep -q "^APP_TOKEN=" $(ENV_FILE); then \
		sed -i'' -e "s/^APP_TOKEN=.*/APP_TOKEN=\"$$TOKEN\"/" $(ENV_FILE); \
	else \
		sed -i'' -e '/^APP_HOST=/a\' -e "APP_TOKEN=\"$$TOKEN\"" $(ENV_FILE); \
	fi
	@echo "Token adicionado com sucesso ao arquivo .env ✅"
	@echo "🚀 Ambiente configurado com sucesso! 🚀"