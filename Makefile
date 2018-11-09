OS := $(shell uname)

start_dev:
ifeq ($(OS),Darwin)
	docker volume create --name=app-web
	docker-compose up -d
	docker-sync start
else
	docker-compose -f docker-compose.yml -f docker-compose.linux.yml up -d
endif

stop_dev:           ## Stop the Docker containers
ifeq ($(OS),Darwin)
	docker-compose stop
	docker-sync stop
else
	docker-compose stop
endif

################ Sphinx ################
sphinx_rotate:
	docker exec -it hotels-api-sphinx indexer --all --rotate

############### Doctrine ###############
doctrine_migrations_diff:
	docker-compose exec app sh -c 'bin/console doctrine:migration:diff'
doctrine_migrations_apply:
	docker-compose exec app sh -c 'bin/console doctrine:migration:migrate'