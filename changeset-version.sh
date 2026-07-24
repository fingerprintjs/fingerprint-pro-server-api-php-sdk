#!/usr/bin/env bash

set -euo pipefail

pnpm exec changeset version && bash ./scripts/generate.sh
