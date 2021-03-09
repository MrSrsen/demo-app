# mr-srsen/demo-app

Symfony demo app for registration and showing users.

## Containers

* **php**: PHP8 with symfony 5.2
* **mariadb**: MariaDB 10.5 for storing data

## Install

```shell
git clone git@github.com:MrSrsen/demo-app.git
cd demo-app
docker-compose up

# Open in another window and run migrations:
docker-compose exec php bash
symfony console doctrine:migrations:migrate --no-interaction
```

Visit: http://localhost:8000/

For front-end app see: https://github.com/MrSrsen/demo-app-fe

## Run

```shell
docker-compose up
```

## TODO

(Things I was too lazy to do)

* test coverage with some cool CI that would run them with merge-requests
* maybe remove `role` from user API response and move to its own endpoint?
* proper webserver in docker / more production-ready docker?
* Make workaround for that [PHP8 bug](https://www.youtube.com/watch?v=dQw4w9WgXcQ)
* <sup>Fix all the bugs that I did not find</sup>
