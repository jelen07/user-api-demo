#!/usr/bin/env bash

if [[ ! -z "${HEROKU}" ]]; then
  cp .env.dist .env
fi

bin/console doctrine:database:drop --force
bin/console doctrine:database:create
bin/console doctrine:schema:create
