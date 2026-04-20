#!/bin/bash

source "$(dirname "${BASH_SOURCE[0]}")/common.sh"

defaultBaseUrl="https://fingerprintjs.github.io/fingerprint-pro-server-api-openapi"
schemaUrl="${1:-$defaultBaseUrl/schemas/fingerprint-server-api-compact.yaml}"

mkdir -p ./res

CURL_OPTS=(-fSL --retry 3)
if [[ "${TRACE:-}" != "true" && "${ACTIONS_STEP_DEBUG:-}" != "true" ]]; then
  CURL_OPTS+=(-s)
fi

require_cmd curl

echo "Downloading \`$schemaUrl\`..."
curl "${CURL_OPTS[@]}" -o ./res/fingerprint-server-api.yaml "$schemaUrl"

sed_in_place '/IpInfoResult:/,/IpBlockListResult:/ { /dataCenter:/ { N; d; }; }' ./res/fingerprint-server-api.yaml

./scripts/generate.sh
