#!/usr/bin/env bash
#git stash
#git pull

#composer install

php bin/console doctrine:migrations:migrate

npm install
gulp
rm bootstrap.sh
rm Vagrantfile

php bin/console cache:clear --env prod
