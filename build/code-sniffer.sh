PWD=$(pwd)
CURRENT_DIRECTORY=${PWD//cygdrive\//}

docker run \
    --rm \
    --interactive \
    --volume /$CURRENT_DIRECTORY://var/www/html \
    --workdir //var/www/html \
    --env LOGGING_HOST= \
    --env LOGGING_PORT= \
    --entrypoint php \
    php8 \
        vendor/squizlabs/php_codesniffer/bin/phpcs \
        --standard=build/configs/code-sniffer-rules.xml \
        --extensions=php \
        -s \
        src tests
