1. docker-compose up --build -d
2. docker-compose exec app ./vendor/bin/doctrine orm:schema-tool:update --force
3. GET: /fixture/user