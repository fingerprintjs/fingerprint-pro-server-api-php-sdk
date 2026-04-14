---
"@fingerprint/php-sdk": major
---

Migrate to Server API v4.

### Breaking Changes

- Flatten event structure. Access fields directly instead of through `products` wrapper/container.
- Remove `getVisits` and `getRelatedVisitors` endpoints (use `searchEvents` instead).
- Remove deprecated v3 models (webhook models, product wrapper models, etc.).
- Rename `getEvent` parameter `$request_id` to `$event_id`. Return type changed from `array` to `Event`.
- Change `updateEvent` parameter order and body class (`EventsUpdateRequest` → `EventUpdate`). Return type changed from `array` to `void`. HTTP method changed from PUT to PATCH.
- Change `searchEvents` return type from `array` to `EventSearch`. new search parameters added.
- Change `deleteVisitorData` return type from `array` to `void`.
- Require API key in `Configuration` constructor: `new Configuration(string $apiKey)`. Remove `getDefaultConfiguration()` and `setDefaultConfiguration()`.
- Simplify `setApiKey`/`getApiKey` to single-key (no identifier). Remove unnecessary `setApiKeyPrefix`, `setAccessToken`, `setUsername`, `setPassword` methods.
- Switch authentication from API key header to `Authorization: Bearer` token.
- Change all JSON serialization keys from camelCase to snake_case.
- Change `ErrorCode` enum values from PascalCase to snake_case.
- Append `/v4` to all region base URLs.
- Changed method return signature of operations.

### Migration Guide

**Response/Model structure:**
```diff
- $event->getProducts()->getIdentification()->getData()->getVisitorId()
+ $event->getIdentification()->getVisitorId()
```

**Configuration:**
```diff
- $config = Configuration::getDefaultConfiguration('secret-api-key');
+ $config = new Configuration('secret-api-key');
```

**Region parameter:**
```diff
- $config = Configuration::getDefaultConfiguration('key', Configuration::REGION_EUROPE);
+ $config = new Configuration('key', Configuration::REGION_EUROPE);
```

**New operation return format:**
```diff
- list($event, $response) = $api->getEvent($requestId);
+ $event = $api->getEvent($eventId);
```

**If you need raw response:**
```diff
- list($event, $response) = $api->getEvent($requestId);
+ list($event, $response) = $api->getEventWithHttpInfo($eventId);
```

**Update event:**
```diff
- $body = new EventsUpdateRequest(['tag' => ['key' => 'value']]);
- $api->updateEvent($body, $requestId);
+ $body = new EventUpdate(['tags' => ['key' => 'value']]);
+ $api->updateEvent($eventId, $body);
```

### New Features

- New v4 models: `BotInfo`, `Canvas`, `Emoji`, `EventRuleAction`, `RawDeviceAttributes`, `TamperingDetails`, ...
- New enum models: `BotResult`, `TamperingConfidence`, `VpnConfidence`, `ProxyConfidence`, `RuleActionType`, ...
- New `WithHttpInfo` method variants for all operations. Each operation now exposes four methods: `{operationId}()`, `{operationId}WithHttpInfo()`, `{operationId}Async()`, `{operationId}AsyncWithHttpInfo()`.
- mTLS support with `setCertFile()` and `setKeyFile()` on `Configuration`.
