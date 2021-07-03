FROM nginx:latest
# Я обычно не использую latest, но для тестирования подойдет
COPY . /app
COPY ./nginx.conf /etc/nginx/conf.d/default.conf
WORKDIR /app
