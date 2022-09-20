#!/bin/bash

VERSION='1.2.0'

while getopts "v:" arg; do
  case $arg in
    v)
      VERSION=$OPTARG
      ;;
  esac
done

# jar was downloaded from here https://repo1.maven.org/maven2/io/swagger/codegen/v3/swagger-codegen-cli/3.0.34/

java -jar ./bin/swagger-codegen-cli.jar generate -t ./template -l php -i ./res/fingerprint-server-api.yaml -o ./ -c config.json -DpackageVersion=$VERSION

sed -i '' 's/"description": ""/"description": "Fingerprint Pro Server API provides a way for validating visitors’ data issued by Fingerprint Pro."/g' sdk/composer.json
sed -i '' 's/"homepage": "http:\/\/swagger.io"/"homepage": "https:\/\/www.fingerprint.com"/g' sdk/composer.json
sed -i '' 's/"license": "proprietary",/"license": "MIT",/g' sdk/composer.json
sed -i '' 's/"name": "Swagger and contributors",/"name": "fingerprintjs",/g' sdk/composer.json
sed -i '' 's/"homepage": "https:\/\/github.com\/swagger-api\/swagger-codegen"/"homepage": "https:\/\/github.com\/fingerprintjs\/fingerprint-pro-server-api-php-sdk"/g' sdk/composer.json

mv -f sdk/README.md ./README.md
rm -rf docs
mv -f sdk/docs ./docs
rm sdk/{git_push.sh,.php_cs,.travis.yml}