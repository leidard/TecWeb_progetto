
all:
	mysql -h 127.0.0.1 -P 3306 -u root --password=mariadb < DB.sql

server:
	php -S localhost:8080 -t controllers/

connectdb:
	mysql -h 127.0.0.1 -P 3306 -u root --password=mariadb