#!/bin/bash

source "$(dirname "${BASH_SOURCE[0]}")/common.sh"

require_cmd docker

docker container run --env-file .env --rm -v "${PWD}:/app/" php:8.1-cli php /app/run_checks.php
