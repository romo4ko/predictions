To run application
create local Postgres database or run
```
docker compose up -d
```
Edit .env file to match your database settings, then run
```
symfony server:start
```
To run migrations
```
php bin/console doctrine:migrations:migrate
```