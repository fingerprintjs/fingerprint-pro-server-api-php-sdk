#!/bin/bash

curl -o ./res/fingerprint-server-api.yaml https://fingerprintjs.github.io/fingerprint-pro-server-api-openapi/schemas/fingerprint-server-api-compact.yaml

examplesList=(
  'get_visits_200_limit_1.json'
  'get_visits_200_limit_500.json'
  'get_visits_403_error.json'
  'get_visits_429_too_many_requests_error.json'
  'webhook.json'
  'get_event_200.json'
  'get_event_200_all_errors.json'
  'get_event_200_extra_fields.json'
  'get_event_403_error.json'
  'get_event_404_error.json'
  'get_event_200_botd_failed_error.json'
  'get_event_200_botd_too_many_requests_error.json'
  'get_event_200_identification_failed_error.json'
  'get_event_200_identification_too_many_requests_error.json'
  'update_event_400_error.json'
  'update_event_403_error.json'
  'update_event_404_error.json'
  'update_event_409_error.json'
)

sharedExamplesList=(
  '400_error_empty_visitor_id.json'
  '400_error_incorrect_visitor_id.json'
  '403_error_feature_not_enabled.json'
  '403_error_token_not_found.json'
  '403_error_token_required.json'
  '403_error_wrong_region.json'
  '404_error_visitor_not_found.json'
  '429_error_too_many_requests.json'
)

for example in ${examplesList[*]}; do
  curl -o ./test/mocks/"$example" https://fingerprintjs.github.io/fingerprint-pro-server-api-openapi/examples/"$example"
done

for example in ${sharedExamplesList[*]}; do
  curl -o ./test/mocks/"$example" https://fingerprintjs.github.io/fingerprint-pro-server-api-openapi/examples/shared/"$example"
done

sed -i '' '/IpInfoResult:/,/IpBlockListResult:/ { /dataCenter:/ { N; d; }; }' ./res/fingerprint-server-api.yaml

./scripts/generate.sh
