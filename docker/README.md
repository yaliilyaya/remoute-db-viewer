
## for start LEMP:
```bash
docker-compose up -d --build
docker-compose exec service composer install -vvv
docker-compose exec service php bin/console server:start *:80 --no-ansi
docker-compose exec service php bin/console doctrine:migrations:migrate --no-ansi
```

### for stop LEMP:
`` docker-compose down -v``


### Update
```bash
docker-compose exec service php bin/console  cache:clear --no-ansi
```