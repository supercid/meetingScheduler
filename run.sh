#!/usr/bin/env bash

composer install
php bin/console cache:clear
php bin/console cache:clear --env=test
php bin/console assets:install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --force --env=test
php bin/console doctrine:fixtures:load -q
php bin/console doctrine:fixtures:load -q --env=test
php phpunit.phar
php bin/console server:run