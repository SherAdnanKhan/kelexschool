#!/bin/bash

php composer dump-autoload
php artisan clear:config
php artisan migrate
php artisan serve --host=0.0.0.0 --port=8000