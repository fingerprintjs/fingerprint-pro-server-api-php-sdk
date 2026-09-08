---
"fingerprint-pro-server-api-php-sdk": minor
---

Handle additional error responses:

- `getEvent`: `429` and `504`
- `searchEvents`: `404`, `429`, and `504`
- `getVisits`: `404` and `504`

Add `REQUEST_READ_TIMEOUT` to the `ErrorCode` enum.
