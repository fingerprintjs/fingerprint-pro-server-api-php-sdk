#!/bin/bash

source "$(dirname "${BASH_SOURCE[0]}")/common.sh"

require_cmd docker

docker compose run composer install --profile --ignore-platform-reqs --no-interaction --no-ansi --no-scripts --prefer-dist
