## for start docker:
```bash
docker-compose up -d --build
docker-compose exec app composer install -vvv
```

### for stop docker:
`` docker-compose down -v``


### Update
```bash
docker-compose exec app php bin/console cache:clear --no-ansi
docker-compose exec app php bin/console doctrine:migrations:diff --no-ansi
```