---
"@fingerprint/php-sdk": major
---

Changed package name to `fingerprint/server-sdk`

**BREAKING CHANGE**:
- Update the composer dependency to `fingerprint/server-sdk`
- Update all `use` statements to the new namespace `Fingerprint\ServerSdk`

**MIGRATION GUIDE**:

Replace `composer.json` dependency:

```diff
"require": {
-    "fingerprint/fingerprint-pro-server-api-sdk": "^6.10.0"
+    "fingerprint/server-sdk": "^7.0.0"
}
```

Replace all `use` statements with the new namespace:

```diff
-use Fingerprint\ServerAPI\Configuration;
+use Fingerprint\ServerSdk\Configuration;
```

The above example applies to all `Fingerprint\ServerAPI` references.