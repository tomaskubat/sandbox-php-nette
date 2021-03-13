DEV_PROJECT_NAME := sandbox_phpnette
DEV_DOCKER_COMPOSE := docker-compose.yml

ifeq ($(shell uname -s),Darwin)
  DEV_DOCKER_COMPOSE_PLATFORM=docker-compose.macos.yml
else
  DEV_DOCKER_COMPOSE_PLATFORM=docker-compose.linux.yml
endif

docker_compose_cmd = docker-compose -p ${DEV_PROJECT_NAME} -f ${DEV_DOCKER_COMPOSE} -f ${DEV_DOCKER_COMPOSE_PLATFORM} $(1)

up:
	$(call docker_compose_cmd, up)

phpstan:
	$(call docker_compose_cmd, exec php  ./vendor/bin/phpstan)
pull:
	$(call docker_compose_cmd, pull)

update: pull

down:
	$(call docker_compose_cmd, down)

destroy: down

cli_php:
	# docker exec -ti sandbox_phpnette_php sh -l
	$(call docker_compose_cmd, exec php sh -l)

cli_db:
	# docker exec -ti sandbox_phpnette_db sh -l
	$(call docker_compose_cmd, exec db sh -l)

cli_nginx:
	# docker exec -ti sandbox_phpnette_nginx sh -l
	$(call docker_compose_cmd, exec nginx sh -l)

logs:
	# docker logs sandbox_phpnette_php -f
	# docker logs sandbox_phpnette_db -f
	# docker logs sandbox_phpnette_nginx -f
	$(call docker_compose_cmd, logs -f --tail=10 php db nginx)

log_php:
	# docker logs sandbox_phpnette_php -f
	$(call docker_compose_cmd, logs -f --tail=25 php)

log_db:
	# docker logs sandbox_phpnette_db -f
	$(call docker_compose_cmd, logs -f --tail=25 db)

log_nginx:
	# docker logs sandbox_phpnette_nginxp -f
	$(call docker_compose_cmd, logs -f --tail=25 nginx)

mysql_client:
	# docker exec -ti sandbox_phpnette_db mysql --host=127.0.0.1 --port=3306  --user=project --password=project project
	$(call docker_compose_cmd, exec db mysql --host=127.0.0.1 --port=3306  --user=project --password=project project)
