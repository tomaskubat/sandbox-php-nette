DEV_PROJECT_NAME := sandbox_php_nette
DEV_DOCKER_COMPOSE := docker-compose.yml

run:
	docker-compose -p ${DEV_PROJECT_NAME} -f ${DEV_DOCKER_COMPOSE} up

update:
	docker-compose -p ${DEV_PROJECT_NAME} -f ${DEV_DOCKER_COMPOSE} pull

pull: update