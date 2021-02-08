#!/usr/bin/env sh
set -ev

sh -c "if [ '$DB' = 'pdo_mysql' ]; then mysql -e 'create database IF NOT EXISTS $DB_NAME' -u$DB_USER; fi"

phpenv config-rm xdebug.ini

if [ "${TRAVIS_PHP_VERSION}" != "hhvm" ]; then
    PHP_INI_DIR="$HOME/.phpenv/versions/$(phpenv version-name)/etc/conf.d/"
    TRAVIS_INI_FILE="$PHP_INI_DIR/travis.ini"
    echo "memory_limit=3072M" >> "$TRAVIS_INI_FILE"
fi

composer require "symfony/symfony:${SYMFONY_VERSION}" --no-update
