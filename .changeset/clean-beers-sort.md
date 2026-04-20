---
"fingerprint-pro-server-api-php-sdk": minor
---

- Add `rareDevice` Smart Signal for detecting rare or previously unseen devices.
- **events-search**: Add `rare_device` and `rare_device_percentile_bucket` filter parameters.
- Add `type` property to `IPInfoASN`.
- Add `integrations` property to the `SDK` model.
- Add `confidence` and `mlScore` properties to the `Tampering` signal.
- Add `mlScore` property to the `VirtualMachine` signal.
- Add `WORKSPACE_SCOPED_SECRET_KEY_REQUIRED` to the `ErrorCode` enum.
- **webhook**: Add `rareDevice` property to the Webhook schema.
- **webhook**: Add `confidence` and `mlScore` properties to `WebhookTampering`.
- **webhook**: Add `mlScore` property to `WebhookVirtualMachine`.
