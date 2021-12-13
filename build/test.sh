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
        vendor/phpunit/phpunit/phpunit \
        --configuration build/configs/phpunit.xml.dist \
        --coverage-html coverage
