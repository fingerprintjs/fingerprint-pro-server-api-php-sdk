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

mv -f sdk/README.md ./README.md
rm -rf sdk/composer.json
rm -rf docs
mv -f sdk/docs ./docs
rm -rf sdk/test
rm sdk/{git_push.sh,.php_cs,.travis.yml,phpunit.xml.dist}