# Notification publisher app

![image](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![image](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=Symfony&logoColor=white)
![image](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)

This project is designed to showcase a notification publisher application implemented with Domain-Driven Design and CQRS principles.

## Start

1. Clone repository from `git@github.com:Przemek-93/notification_publisher_app.git`
2. Install Makefile - https://makefiletutorial.com/
3. Install Docker - https://docs.docker.com/
4. In the console get into the main project directory and type `make` or `make build`
5. Wait until the installation process is done
6. Run `make up` to start container
7. Run `make composer` to install composer dependencies
8. After the first installation use `make up` and `make stop` to turn on and turn off the project

## Useful commands

- `make build` - build project, shortcut for `docker compose build --no-cache`
- `make composer` - install composer dependencies `docker compose exec php composer install`
- `make up` - turns on the project, shortcut for `docker compose up -d`
- `make stop` - stops all containers, shortcut for `docker compose stop`
- `make bash` - cli for php container, shortcut for `docker compose exec php bash`
- `make xon` - enable xdebug
- `make xoff` - disable xdebug
- `make fix` - automatically fixing code style by PHP Code Sniffer   
- `make analyse` - start static analyse
- `make test` - start PHPUnit tests