Run docker-compose up for start docker containers.

check containers 

`docker ps`

go to php-fpm container and run

`composer install`

`./bin/console doctrine:migrations:migrate`

go to encore container and

`run yarn install`

`yarn build`



launch the app at this 

`http://localhost:8002/app/`