# Тестовое задание на позицию backend разработчика agroru

## Запуск приложения.

* git clone https://github.com/windstep/test_auto.git
* cd test_auto
* cp .env.example .env
* composer install
* docker-compose up -d
* docker-compose exec backend php artisan migrate --seed
* http://localhost/api/healthcheck

## Проверка работоспособности

Достаточно запустить тесты и отправить
POST запрос на http://localhost/api/usage

В качестве параметров запроса необходимо указать:
car_id - ID машины
user_id - ID пользователя
time_from - период начала использования
time_to - период окончания использования

Все время указывается в формате доступном для прочтения с помощью функции strtotime

OAPI спека находится в swagger/swagger.yml

## Запуск тестов

* docker-compose exec testing vendor/bin/phpunit

## Анализ кода.

Начинайте с файлика routes/web.php, переходите к контроллерам, далее все будет понятно)
