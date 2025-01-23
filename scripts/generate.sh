#!/bin/bash

shopt -s extglob

VERSION=$(jq -r '.version' package.json)

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
    sed -i '' "s/\"artifactVersion\": \".*\"/\"artifactVersion\": \"$VERSION\"/g" config.json
  else
    sed -i "s/\"artifactVersion\": \".*\"/\"artifactVersion\": \"$VERSION\"/g" config.json
  fi
)

# clean models before generating
rm -f ./src/Model/*

java -jar ./bin/swagger-codegen-cli.jar generate -t ./template -l php -i ./res/fingerprint-server-api.yaml -o ./ -c config.json --type-mapping RawDeviceAttributes=array,WebhookRawDeviceAttributes=array,Tag=array,GeolocationSubdivisions=array

if [ ! -f .php-cs-fixer.php ]; then
  echo ".php-cs-fixer.php configuration file not found!"
  exit 1
fi

echo "Using .php-cs-fixer.php configuration:"
cat .php-cs-fixer.php

docker run --rm -v $(pwd):/code ghcr.io/php-cs-fixer/php-cs-fixer:3.64-php8.3 fix --config=/code/.php-cs-fixer.php

# fix invalid code generated for Models and docs
(
  # Model and docs files fix
  if [ "$platform" = "Darwin" ]; then
    sed -i '' 's/\\Fingerprint\\ServerAPI\\Model\\array/array/' ./src/Model/*
    sed -i '' 's/\\Fingerprint\\ServerAPI\\Model\\mixed/mixed/' ./src/Model/*
    sed -i '' 's/?mixed/mixed/' ./src/Model/*
    sed -i '' 's/\[\*\*\\Fingerprint\\ServerAPI\\Model\\array\*\*\](array\.md)/array/' ./src/docs/Model/*
    sed -i '' 's/\[\*\*\\Fingerprint\\ServerAPI\\Model\\mixed\*\*\](mixed\.md)/mixed/' ./src/docs/Model/*

  else
    sed -i 's/\\Fingerprint\\ServerAPI\\Model\\array/array/' ./src/Model/*
    sed -i 's/\\Fingerprint\\ServerAPI\\Model\\mixed/mixed/' ./src/Model/*
    sed -i 's/?mixed/mixed/' ./src/Model/*
    sed -i 's/\[\*\*\\Fingerprint\\ServerAPI\\Model\\array\*\*\](array\.md)/array/' ./src/docs/Model/*
    sed -i 's/\[\*\*\\Fingerprint\\ServerAPI\\Model\\mixed\*\*\](mixed\.md)/mixed/' ./src/docs/Model/*
  fi
)

# cleanup replaced models from readme
(
  patterns=(
  '\[RawDeviceAttribute\](docs\/Model\/RawDeviceAttribute\.md)'
  '\[RawDeviceAttributeError\](docs\/Model\/RawDeviceAttributeError\.md)'
  '\[RawDeviceAttributes\](docs\/Model\/RawDeviceAttributes\.md)'
  '\[WebhookRawDeviceAttributes\](docs\/Model\/WebhookRawDeviceAttributes\.md)'
  '\[Tag\](docs\/Model\/Tag\.md)'
  '\[GeolocationSubdivisions\](docs\/Model\/GeolocationSubdivisions\.md)'
  '\[GeolocationSubdivision\](docs\/Model\/GeolocationSubdivision\.md)'
  )
  if [ "$platform" = "Darwin" ]; then
    for pattern in "${patterns[@]}"; do
        sed -i '' "/$pattern/d" src/README.md
    done
  else
    for pattern in "${patterns[@]}"; do
        sed -i "/$pattern/d" src/README.md
    done
  fi
)

mv -f src/README.md ./README.md
mv -f src/composer.json composer.json
rm ./docs/Api/*
rm ./docs/Model/*
mv -f src/docs/* ./docs
