up:
	docker-compose up -d

down:
	docker-compose down

restart:
	docker-compose restart

php:
	docker exec -it -w /var/www/html/App personal_blog_tania_php bash

logs:
	docker-compose logs -f

install: up
	docker exec -it -w /var/www/html personal_blog_tania_php bash -c "composer install && php App/migrations.php"

reset: down
	sudo rm -rf postgres-data
	sudo rm -rf vendor

psql:
	docker exec -it personal_blog_tania_pg psql -U postgres
