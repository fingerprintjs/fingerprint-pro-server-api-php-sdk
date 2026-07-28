#!/bin/bash

source "$(dirname "${BASH_SOURCE[0]}")/common.sh"

require_cmd docker

docker compose run phpunit
