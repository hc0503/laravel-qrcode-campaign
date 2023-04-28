#!/bin/bash

cd /app
wait-for-it db:3306 -t 45

if [ "$FIRST_RUN" == "true" ]; then
    php artisan key:generate
    echo yes | php artisan migrate
    echo yes | php artisan db:seed
    sed '/FIRST_RUN=true/c\FIRST_RUN=false' ./.env.sys > .new_env
    cat .new_env > .env.sys
    rm -f .new_env
fi
php artisan storage:link
php artisan serve --host=0.0.0.0
