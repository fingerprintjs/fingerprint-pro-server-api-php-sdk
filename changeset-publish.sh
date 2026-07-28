#!/usr/bin/env bash

set -euo pipefail

bash ./scripts/generate.sh && pnpm exec changeset publish
