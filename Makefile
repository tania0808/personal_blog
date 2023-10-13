up:
	docker-compose up

down:
	docker-compose down

restart:
	docker-compose restart

php:
	docker exec -it -w /var/www/html/App blog_php_1 bash

logs:
	docker-compose logs -f