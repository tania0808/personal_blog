up:
	docker-compose up -d

down:
	docker-compose down

restart:
	docker-compose restart

php:
	docker exec -it -w /var/www/html/App blog_php_1 bash

logs:
	docker-compose logs -f

install: up
	sleep 2
	docker exec -it -w /var/www/html/App blog_php_1 bash -c "php migrations.php"

reset: down
	sudo rm -rf postgres-data
