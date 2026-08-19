FROM php:8.5-cli-alpine

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

CMD ["tail", "-f", "/dev/null"]
