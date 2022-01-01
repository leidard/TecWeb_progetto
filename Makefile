HOST="db"

all:
	mysql -h ${HOST} -P 3306 -u root --password=mariadb < DB.sql

server:
	php -S localhost:8080 -t controllers/

connectdb:
	mysql -h ${HOST} -P 3306 -u root --password=mariadb