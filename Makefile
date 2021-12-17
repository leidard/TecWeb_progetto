
server:
	php -S localhost:8080 -t controllers/

importdb:
	mysql -h 127.0.0.1 -P 3306 -u root --password=mariadb < DB.sql

connectdb:
	mysql -h 127.0.0.1 -P 3306 -u root --password=mariadb