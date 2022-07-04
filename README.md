# WineBarSys Project
## Start project for developer

Clone laradock from laradock.io:
````
git clone https://github.com/Laradock/laradock.git
````
Config .env
````
cd laradock
cp .env.example .env
vi .env
````
`Config MYSQL and NGINX`
`MYSQL version 5.7`
`PHP 7.4`

Build NGINX and MYSQL
````
docker-compose build nginx mysql
docker-compose up -d nginx mysql
docker-compose exec workspace bash
````
In workspace install composer
````
composer install
composer dump-autoload
php artisan key:gene
php artisan migrate
php artisan db:seed
php artisan jwt:secret
````
Out workspace, visit WineBarSys Project and config .env
````
cp .env.example .env
vi .env
````
`Config Database Connection`
## For Developer
Create Controller
````
php artisan make:controller {name}Controller --resource
````
Create migration
````
php artisan make:migration create_flights_table
````
Create Enum
````
php artisan make:enum {UserRole}
````
