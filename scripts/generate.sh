#!/bin/bash

shopt -s extglob

VERSION='2.0.0'

while getopts "v:" arg; do
  case $arg in
    v)
      VERSION=$OPTARG
      ;;
  esac
done

# jar was downloaded from here https://repo1.maven.org/maven2/io/swagger/codegen/v3/swagger-codegen-cli/3.0.34/

if [[ $VERSION == *"develop"* ]]; then
  SANITIZED_VERSION=$(sed 's/-develop//g' <<< $VERSION)
  SANITIZED_VERSION=$(sed 's/\.[0-9]*$//g' <<< $SANITIZED_VERSION)
  BUILD_VERSION=$(grep -o '[0-9]*$' <<< $VERSION)
  VERSION="dev-$SANITIZED_VERSION-$BUILD_VERSION"
fi

echo "VERSION: $VERSION"

# Platform check
platform=$(uname)
(
  # Model file fix
  if [ "$platform" = "Darwin" ]; then
    echo "Don't bump version in dev env"
    # sed -i '' "s/\"artifactVersion\": \".*\"/\"artifactVersion\": \"$VERSION\"/g" config.json
  else
    sed -i "s/\"artifactVersion\": \".*\"/\"artifactVersion\": \"$VERSION\"/g" config.json
  fi
)

# clean models before generating
rm -f ./src/Model/*

java -jar ./bin/swagger-codegen-cli.jar generate -t ./template -l php -i ./res/fingerprint-server-api.yaml -o ./ -c config.json

# fix invalid code generated for structure with additionalProperties
(
  # Model file fix
  if [ "$platform" = "Darwin" ]; then
    sed -i '' 's/$invalidProperties = parent::listInvalidProperties();/$invalidProperties = [];/' ./src/Model/RawDeviceAttributesResult.php
  else
    sed -i 's/$invalidProperties = parent::listInvalidProperties();/$invalidProperties = [];/' ./src/Model/RawDeviceAttributesResult.php
  fi
)

(
  # Readme file fix
  replacement=$(printf 'The rawAttributes object follows this general shape: `{ value: any } | { error: { name: string; message: string; } }`\n')
  readme_filename="./src/docs/Model/RawDeviceAttributesResult.md"
  if [ "$platform" = "Darwin" ]; then
    sed -i '' "s/^Name |.*/${replacement}/" "$readme_filename"
    sed -i '' "/^------------ |/c\\" "$readme_filename"
  else
    sed -i "s/^Name |.*/${replacement}/" "$readme_filename"
    sed -i "/^------------ |/c\\" "$readme_filename"
  fi
)

mv -f src/README.md ./README.md
mv -f src/composer.json composer.json
find ./docs -type f ! -name "DecryptionKey.md" ! -name "Sealed.md" -exec rm {} +
mv -f src/docs/* ./docs
cp template/docs/FingerprintApi.md docs/Api

# enable WithRawResponse trait for EventResponse model
(
  if [ "$platform" = "Darwin" ]; then
    sed -i '' 's/\/\/ use \\/use \\/' ./src/Model/EventResponse.php
  else
    sed -i 's/\/\/ use \\/use \\/' ./src/Model/EventResponse.php
  fi
)

# enable WithRawResponse trait for Response model
(
  if [ "$platform" = "Darwin" ]; then
    sed -i '' 's/\/\/ use \\/use \\/' ./src/Model/Response.php
  else
    sed -i 's/\/\/ use \\/use \\/' ./src/Model/Response.php
  fi
)