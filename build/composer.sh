PWD=$(pwd)
CURRENT_DIRECTORY=${PWD//cygdrive\//}

docker run \
    --rm \
    --interactive \
    --volume /$CURRENT_DIRECTORY://var/www/html \
    --workdir //var/www/html \
    --env LOGGING_HOST= \
    --env LOGGING_PORT= \
    composer $@
