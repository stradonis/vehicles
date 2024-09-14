Run docker-compose up for start docker containers.

check containers

`docker ps`

go to php-fpm container and run

`composer install`

`./bin/console doctrine:migrations:migrate`

go to encore container and run

`yarn install`

`yarn build`

create or edit your .env file, copy the data from .env.dev and then complete the data in:

`MAILER_DSN` (here, for example, you can use the account from https://mailtrap.io/ for testing)

if necessary, also change the email addresses in:

`NOTIFICATION_EMAIL_FROM`

`NOTIFICATION_EMAIL_TO`



launch the app at this

`http://localhost:8002/app/`

rabbit

`http://localhost:15672`