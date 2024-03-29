#!/bin/bash

curl -o ./res/fingerprint-server-api.yaml https://fingerprintjs.github.io/fingerprint-pro-server-api-openapi/schemas/fingerprint-server-api-compact.yaml

examplesList=(
  'get_visits_200_limit_500.json'
  'get_event_200.json'
  'get_event_200_all_errors.json'
  'get_event_200_extra_fields.json'
)

for example in ${examplesList[*]}; do
  curl -o ./test/mocks/"$example" https://fingerprintjs.github.io/fingerprint-pro-server-api-openapi/examples/"$example"
done

# PHP function names are case insensitive, so we can just ignore wrong DataCenter value from INTER-481 bug.
# this command looks between IpInfoResult and IpBlockListResult strings and deletes the line with "dataCenter:" and next one if found
sed -i '' '/IpInfoResult:/,/IpBlockListResult:/ { /dataCenter:/ { N; d; }; }' ./res/fingerprint-server-api.yaml

./scripts/generate.sh
