#!/bin/bash

source "$(dirname "${BASH_SOURCE[0]}")/common.sh"

#############
# Constants #
#############
OPENAPI_GENERATOR_IMAGE_VERSION="7.21.0"

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

rm -Rf ./src/**
rm -Rf ./docs/**
rm -f README.md
rm -f composer.json

docker run --rm -u "$(id -u):$(id -g)" -v "${PWD}:/local" -w /local \
  "openapitools/openapi-generator-cli:v${OPENAPI_GENERATOR_IMAGE_VERSION}" generate \
  -t ./template \
  -g php \
  -i ./res/fingerprint-server-api.yaml \
  -o ./ \
  -c ./config.json

# Fix documentation file enum usage
DOC_FILE="docs/Api/FingerprintApi.md"
NS="\\\\Fingerprint\\\\ServerSdk\\\\Model\\\\"

sed_in_place "s|new ${NS}${NS}SearchEventsBot()|${NS}SearchEventsBot::GOOD|g" "$DOC_FILE"
sed_in_place "s|new ${NS}${NS}SearchEventsSdkPlatform()|${NS}SearchEventsSdkPlatform::JS|g" "$DOC_FILE"
sed_in_place "s|new ${NS}${NS}SearchEventsIncrementalIdentificationStatus|${NS}SearchEventsIncrementalIdentificationStatus::COMPLETED|g" "$DOC_FILE"
sed_in_place "s|new ${NS}${NS}SearchEventsVpnConfidence()|${NS}SearchEventsVpnConfidence::MEDIUM|g" "$DOC_FILE"

# Fix phpDoc type issue for `searchEvents`
API_FILE="src/Api/FingerprintApi.php"
sed_in_place 's/@param  int|null \$limit/@param  int \$limit/' "$API_FILE"

# Format generated code
"$(dirname "${BASH_SOURCE[0]}")/php-cs-fixer.sh" -vvv
