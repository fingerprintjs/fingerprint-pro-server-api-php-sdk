#!/bin/bash

curl -o ./res/fingerprint-server-api.yaml https://fingerprintjs.github.io/fingerprint-pro-server-api-openapi/schemes/fingerprint-server-api.yaml

examplesList=(
  'visits_limit_500.json'
  'get_event.json'
  'get_event_all_errors.json'
  'get_event_extra_fields.json'
)

for example in ${examplesList[*]}; do
  curl -o ./test/mocks/"$example" https://fingerprintjs.github.io/fingerprint-pro-server-api-openapi/examples/"$example"
done

./scripts/generate.sh
