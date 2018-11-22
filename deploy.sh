#!/usr/bin/env bash
#git stash
#git pull

#composer install

php bin/console doctrine:migrations:migrate

npm install
gulp

php bin/console cache:clear --env prod
