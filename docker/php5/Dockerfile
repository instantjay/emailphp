FROM alpine:latest

RUN apk update --no-cache
RUN apk add php5
RUN apk add php5-ctype

ENTRYPOINT ["php5", "/var/www/emailphp/vendor/bin/phpunit", "/var/www/emailphp/tests/", "--testdox-text", "/var/testoutput/php5-test.txt"]