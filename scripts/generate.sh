#!/bin/bash

VERSION='1.0.0'

while getopts "v:" arg; do
  case $arg in
    v)
      VERSION=$OPTARG
      ;;
  esac
done

# jar was downloaded from here https://repo1.maven.org/maven2/io/swagger/codegen/v3/swagger-codegen-cli/3.0.34/

java -jar ./bin/swagger-codegen-cli.jar generate -t ./template -l php -i ./res/fingerprint-server-api.yaml -o ./ -c config.json

mv -f src/README.md ./README.md
mv -f src/composer.json composer.json
rm -rf docs
mv -f src/docs ./docs
rm -rf src/test
rm src/{git_push.sh,.php_cs,.travis.yml,phpunit.xml.dist}
sed -i "s/\"version\": \"[0-9]*\.[0-9]*\.[0-9]*\"/\"version\": \"$VERSION\"/g" composer.json