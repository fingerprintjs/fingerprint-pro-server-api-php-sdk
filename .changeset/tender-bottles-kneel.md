---
'fingerprint-pro-server-api-php-sdk': patch
---

- Remove all `example` YAML attributes from all the properties due to [deprecation](https://spec.openapis.org/oas/v3.1.0#fixed-fields-19).
  - Keep using JSON Schema `examples` with the `externalValue` associated with JSON example from `/schemas/paths/examples`.
- Reorder all the `schemas` fields (e.g. `type` -> `format` -> `description` -> `required` -> `properties`).
- Reorder all the `paths` fields (e.g. `tags` -> `summary` -> `description` -> `parameters` -> ...)
- Reorder all the object properties in the order they returned by API.
- Move existing and add new error examples to `/schemas/paths/examples/errors`.
- Replace GET /events TooManyRequests examples with a single `get_event_200_too_many_requests_error.json`.
- Update `products.identification.error.message` in `get_event_200_<...>.json` examples.
- Rename GET /visitors example files.