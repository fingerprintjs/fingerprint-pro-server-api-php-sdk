# ErrorCode
Error code:
 * `RequestCannotBeParsed` - the query parameters or JSON payload contains some errors 
          that prevented us from parsing it (wrong type/surpassed limits).
 * `TokenRequired` - `Auth-API-Key` header is missing or empty.
 * `TokenNotFound` - no Fingerprint application found for specified secret key.
 * `SubscriptionNotActive` - Fingerprint application is not active.
 * `WrongRegion` - server and application region differ.
 * `FeatureNotEnabled` - this feature (for example, Delete API) is not enabled for your application.
 * `RequestNotFound` - the specified request ID was not found. It never existed, expired, or it has been deleted.
 * `VisitorNotFound` - The specified visitor ID was not found. It never existed or it may have already been deleted.
 * `TooManyRequests` - the limit on secret API key requests per second has been exceeded.
 * `429 Too Many Requests` - the limit on secret API key requests per second has been exceeded.
 * `StateNotReady` - The event specified with request id is
          not ready for updates yet. Try again.
          This error happens in rare cases when update API is called immediately
          after receiving the request id on the client. In case you need to send
          information right away, we recommend using the JS agent API instead.
 * `Failed` - internal server error.


