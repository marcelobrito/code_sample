# Run the app

```bash
cp .env.example .env # only for the first time
docker-compose up -d
docker exec php-code-sample npm install # only for the first time
docker exec php-code-sample php artisan migrate # only for the first time
```
The app will be running on [localhost:8001](http://localhost:8000).
- email: marcelo.nakash@gmail.com
- password: 123456

To execute the end-to-end tests, run the command:
```bash
docker run --network host -it -v $PWD/e2e:/e2e -w /e2e cypress/included:4.10.0
```

To execute the integration tests, run the command:

```bash
docker exec php-code-sample php artisan test:create-test-database # only for the first time
docker exec php-code-sample ./vendor/bin/phpunit
```

## PHPCS

To validate the code style run the command:

```bash
docker exec php-code-sample ./vendor/bin/phpcs --standard=phpcs.xml 
```

To automatically fix code style issues run the command:

```bash
docker exec php-code-sample ./vendor/bin/phpcbf --standard=phpcs.xml 
```

## PHPMD

To validate the code quality run the command:

```bash
docker exec php-code-sample ./vendor/bin/phpmd app text phpmd.xml
```
