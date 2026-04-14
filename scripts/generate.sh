#!/bin/bash

source "$(dirname "${BASH_SOURCE[0]}")/common.sh"

#############
# Constants #
#############
SWAGGER_CODEGEN_IMAGE_VERSION="3.0.78"
PHP_CS_FIXER_IMAGE_VERSION="3.64-php8.3"

######################
# Version Resolution #
######################
require_cmd jq
VERSION=$(jq -r '.version' package.json)

while getopts "v:" arg; do
  # shellcheck disable=SC2220
  case $arg in
    v)
      VERSION=$OPTARG
      ;;
  esac
done

VERSION=${VERSION//develop/dev}

# Convert development version strings into PHP-semver-compatible beta versions.
if [[ $VERSION =~ ^dev[.-]([0-9]+)[.-]([0-9]+)[.-]([0-9]+)[.-]([0-9]+)$ ]]; then
  # Example for the regex above:
  # dev.1.0.0.0
  # dev-1.0.0-0
  # dev.1.0.0-0
  # dev-1.0.0.0
  VERSION="${BASH_REMATCH[1]}.${BASH_REMATCH[2]}.${BASH_REMATCH[3]}-beta.${BASH_REMATCH[4]}"
elif [[ $VERSION =~ ^([0-9]+)[.-]([0-9]+)[.-]([0-9]+)[.-]dev[.-]([0-9]+)$ ]]; then
  # Example for the regex above:
  # 1.0.0.dev.0
  # 1.0.0.dev-0
  # 1.0.0-dev-0
  # 1.0.0-dev.0
  VERSION="${BASH_REMATCH[1]}.${BASH_REMATCH[2]}.${BASH_REMATCH[3]}-beta.${BASH_REMATCH[4]}"
elif [[ $VERSION == dev-* ]]; then
  _temp_part=${VERSION#dev-}
  VERSION="${_temp_part//-/.}-beta"
elif [[ $VERSION == *-dev* ]]; then
  _temp_part=${VERSION#*-dev}
  _temp_part=${_temp_part//-/.}
  VERSION="${VERSION%%-dev*}-beta$_temp_part"
fi

echo "VERSION: $VERSION"

# Update `config.json` version
sed_in_place "s/\"artifactVersion\": \".*\"/\"artifactVersion\": \"$VERSION\"/g" config.json

################
# Generate SDK #
################
require_cmd docker

rm -f ./src/Model/*

docker run --rm -u "$(id -u):$(id -g)" -v "${PWD}:/local" -w /local \
  "swaggerapi/swagger-codegen-cli-v3:${SWAGGER_CODEGEN_IMAGE_VERSION}" generate \
  -t ./template \
  -l php \
  -i ./res/fingerprint-server-api.yaml \
  -o ./ \
  -c ./config.json \
  --type-mapping RawDeviceAttributes=array,WebhookRawDeviceAttributes=array,Tag=array,GeolocationSubdivisions=array

# Format generated code
if [ ! -f .php-cs-fixer.php ]; then
  echo ".php-cs-fixer.php configuration file not found!"
  exit 1
fi

docker run --rm -u "$(id -u):$(id -g)" -v "${PWD}:/code" \
  "ghcr.io/php-cs-fixer/php-cs-fixer:${PHP_CS_FIXER_IMAGE_VERSION}" fix \
  --config=/code/.php-cs-fixer.php

# Fix generated code
sed_in_place_glob 's/\\Fingerprint\\ServerSdk\\Model\\array/array/' ./src/Model/*
sed_in_place_glob 's/\\Fingerprint\\ServerSdk\\Model\\mixed/mixed/' ./src/Model/*
sed_in_place_glob 's/?mixed/mixed/' ./src/Model/*
sed_in_place_glob 's/\[\*\*\\Fingerprint\\ServerSdk\\Model\\array\*\*\](array\.md)/array/' ./src/docs/Model/*
sed_in_place_glob 's/\[\*\*\\Fingerprint\\ServerSdk\\Model\\mixed\*\*\](mixed\.md)/mixed/' ./src/docs/Model/*

# Cleanup documentation
patterns=(
  '\[RawDeviceAttribute\](docs\/Model\/RawDeviceAttribute\.md)'
  '\[RawDeviceAttributeError\](docs\/Model\/RawDeviceAttributeError\.md)'
  '\[RawDeviceAttributes\](docs\/Model\/RawDeviceAttributes\.md)'
  '\[WebhookRawDeviceAttributes\](docs\/Model\/WebhookRawDeviceAttributes\.md)'
  '\[Tag\](docs\/Model\/Tag\.md)'
  '\[GeolocationSubdivisions\](docs\/Model\/GeolocationSubdivisions\.md)'
  '\[GeolocationSubdivision\](docs\/Model\/GeolocationSubdivision\.md)'
)
for pattern in "${patterns[@]}"; do
  sed_in_place "/$pattern/d" src/README.md
done

# Move generated files
mv -f src/README.md ./README.md
mv -f src/composer.json composer.json
rm ./docs/Api/*
rm ./docs/Model/*
mv -f src/docs/* ./docs
