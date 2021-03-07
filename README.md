PHP & Nette Framework Sandbox
=============================

Base docker based stack for PHP application with [Nette framwework](https://nette.org/en/).

It is based on prepared [public docker images](https://gitlab.com/tomaskubat-sandbox/containers/container_registry) availabled for production environment as well as development environment. 

Contains templates for CI/CD integration. 

Prerequisites
-------------
- [Docker (Engine)](https://docs.docker.com/engine/install/) on Linux or [Docker Desktop for Mac](https://docs.docker.com/docker-for-mac/install/) or [Windows](https://docs.docker.com/docker-for-windows/install/)
- [Docker Compose](https://docs.docker.com/compose/install/) only on Linux (on Docker Desktop for Mac/Windows is included as part of those desktop installs). 
- (Optional) [Bash or Zsh completion](https://docs.docker.com/compose/completion/) for Docker and Docker Compose

Usage
-----
- Copy whole repository content as basis for new application.
- Update exposed ports in `docker-compose.yml` file.
- Fit project name to variable `DEV_PROJECT_NAME` in `Makefile` file.
- Use `Makefile` as bookmark of shortcuts.

Makefile
--------

| Command           | Description |
| ----------------- | ----------------------------------------------------- |
| `up`              | Up containers. Stop its by `Ctrl-C`.                  |
| `pull`            | Update images.                                        |
| `down`            | Destroy containers. Next `up` run freshly containers. |
| `destroy`         | is alias for `down`.                                  |
| `cli_php`         | Exec shell on php container.                          |
| `cli_db`          | Exec shell on db container.                           |
| `cli_nginx`       | Exec shell on nginx container.                        |
| `logs`            | Follow stdout/stderr for php/db/nginx containers.     |
| `log_php`         | Follow stdout/stderr for php container.               |
| `log_db`          | Follow stdout/stderr for db container.                |
| `log_nginx`       | Follow stdout/stderr for nginx container.             |
| `mysql_client`    | Run cli mysql client on db container.                 |

PHP Debug
---------
Development container has preinstaled Xdebug extension. 
For start debug session don't forget enable listening for debug session in PHPStorm.
And then start debug session

- from browser with one of browser extension togling debug cookie
- from php container as `php-debug <FILE>`