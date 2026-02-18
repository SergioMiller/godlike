FROM nginx:1.21.3-alpine

WORKDIR /var/www

#COPY docker/nginx/ssl /etc/ssl

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/nginx.vh.default.conf /etc/nginx/conf.d/default.conf
COPY app /var/www/app/
COPY bootstrap /var/www/bootstrap/
COPY config /var/www/config/
COPY database /var/www/database/
COPY public /var/www/public/
COPY resources /var/www/resources/
COPY routes /var/www/routes/
COPY storage /var/www/storage/
COPY .env /var/www/
