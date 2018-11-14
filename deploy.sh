#!/usr/bin/env bash
#git stash
#git pull

#composer install

php bin/console doctrine:migrations:migrate

npm install
gulp
#rm web/app_dev.php

php bin/console assets:install web
php bin/console cache:clear --env prod
