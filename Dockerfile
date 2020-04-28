FROM php:7.4-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . /generator
WORKDIR /generator
RUN apk add --no-cache git
RUN wget $(curl -s https://api.github.com/repos/humbug/box/releases/latest | grep "browser_download_url.*box.phar" | cut -d : -f 2,3 | tr -d \")
RUN composer global require hirak/prestissimo
RUN composer install

RUN php box.phar compile

FROM php:7.4-alpine

RUN apk --no-cache add git
COPY entrypoint.sh /entrypoint.sh
COPY --from=0 /generator/codingStyleGenerator.phar /generator/codingStyleGenerator.phar
WORKDIR /

ENTRYPOINT ["/entrypoint.sh"]