DEV_PROJECT_NAME := sandbox_phpnette
DEV_DOCKER_COMPOSE := docker-compose.yml

ifeq ($(shell uname -s),Darwin)
  DEV_DOCKER_COMPOSE_PLATFORM=docker-compose.macos.yml
else
  DEV_DOCKER_COMPOSE_PLATFORM=docker-compose.linux.yml
endif

docker_compose_cmd = docker-compose -p ${DEV_PROJECT_NAME} -f ${DEV_DOCKER_COMPOSE} -f ${DEV_DOCKER_COMPOSE_PLATFORM} $(1)

up:
	$(call docker_compose_cmd,up)

down:
	$(call docker_compose_cmd,down)

destroy: down

pull:
	$(call docker_compose_cmd,pull)

cli:
	docker exec -ti sandbox_phpnette_php sh -l

mysql_cli:
	docker exec -ti sandbox_phpnette_db sh -l

mysql_client:
	docker exec -ti sandbox_phpnette_db mysql --host=127.0.0.1 --port=3306  --user=project --password=project project
