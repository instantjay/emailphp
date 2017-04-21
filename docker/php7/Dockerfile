FROM alpine:latest

RUN apk update --no-cache
RUN apk add php7
RUN apk add php7-ctype

ENTRYPOINT ["php7", "/var/www/emailphp/vendor/bin/phpunit", "/var/www/emailphp/tests/", "--testdox-text", "/var/testoutput/php7-test.txt"]