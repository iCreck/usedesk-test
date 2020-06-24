FROM nginx:stable-alpine

ADD ./docker/nginx/usedesk-test.conf /etc/nginx/conf.d/default.conf
ADD src /var/www/html

WORKDIR /var/www/html
RUN ln -s public/storage storage/app/public
RUN chmod -R 777 storage && chmod -R 777 bootstrap/cache