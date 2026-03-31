#!/bin/bash

# Shared utilities for scripts.
# Source this file: source "$(dirname "${BASH_SOURCE[0]}")/common.sh"

set -euo pipefail

# Change working directory to the project root.
REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$REPO_ROOT"

# Verify that required commands are available.
# Usage: require_cmd docker jq
require_cmd() {
  for cmd in "$@"; do
    if ! command -v "$cmd" &>/dev/null; then
      echo "Error: required command '$cmd' is not installed." >&2
      exit 1
    fi
  done
}

# In-place sed that works cross-platform.
# Usage: sed_in_place 'pattern' file [file ...]
sed_in_place() {
  if [ "$(uname)" = "Darwin" ]; then
    sed -i '' "$@"
  else
    sed -i "$@"
  fi
}

# Like sed_in_place but accepts a glob pattern.
# Usage: sed_in_place_glob 'pattern' ./patternWithGlob/*
sed_in_place_glob() {
  local expr="$1"
  shift
  local files=()
  for f in "$@"; do
    [ -f "$f" ] && files+=("$f")
  done
  if [ ${#files[@]} -gt 0 ]; then
    sed_in_place "$expr" "${files[@]}"
  fi
}
