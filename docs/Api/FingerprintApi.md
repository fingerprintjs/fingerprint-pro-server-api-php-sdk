# Fingerprint\ServerAPI\FingerprintApi

All URIs are relative to *https://api.fpjs.io*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteVisitorData**](FingerprintApi.md#deleteVisitorData) | **DELETE** /visitors/{visitor_id} | Delete data by visitor ID
[**getEvent**](FingerprintApi.md#getEvent) | **GET** /events/{request_id} | Get event by request ID
[**getRelatedVisitors**](FingerprintApi.md#getRelatedVisitors) | **GET** /related-visitors | Get Related Visitors
[**getVisits**](FingerprintApi.md#getVisits) | **GET** /visitors/{visitor_id} | Get visits by visitor ID
[**searchEvents**](FingerprintApi.md#searchEvents) | **GET** /events/search | Get events via search
[**updateEvent**](FingerprintApi.md#updateEvent) | **PUT** /events/{request_id} | Update an event with a given request ID

# **deleteVisitorData**
> deleteVisitorData($visitor_id)

Delete data by visitor ID

Request deleting all data associated with the specified visitor ID. This API is useful for compliance with privacy regulations. ### Which data is deleted? - Browser (or device) properties - Identification requests made from this browser (or device)  #### Browser (or device) properties - Represents the data that Fingerprint collected from this specific browser (or device) and everything inferred and derived from it. - Upon request to delete, this data is deleted asynchronously (typically within a few minutes) and it will no longer be used to identify this browser (or device) for your [Fingerprint Workspace](https://dev.fingerprint.com/docs/glossary#fingerprint-workspace).  #### Identification requests made from this browser (or device) - Fingerprint stores the identification requests made from a browser (or device) for up to 30 (or 90) days depending on your plan. To learn more, see [Data Retention](https://dev.fingerprint.com/docs/regions#data-retention). - Upon request to delete, the identification requests that were made by this browser   - Within the past 10 days are deleted within 24 hrs.   - Outside of 10 days are allowed to purge as per your data retention period.  ### Corollary After requesting to delete a visitor ID, - If the same browser (or device) requests to identify, it will receive a different visitor ID. - If you request [`/events` API](https://dev.fingerprint.com/reference/getevent) with a `request_id` that was made outside of the 10 days, you will still receive a valid response. - If you request [`/visitors` API](https://dev.fingerprint.com/reference/getvisits) for the deleted visitor ID, the response will include identification requests that were made outside of those 10 days.  ### Interested? Please [contact our support team](https://fingerprint.com/support/) to enable it for you. Otherwise, you will receive a 403.

### Example
```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

const FPJS_API_SECRET = "Your Fingerprint Secret API Key"; // Fingerprint Secret API Key

// Import Fingerprint Classes and Guzzle HTTP Client
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Create new Configuration instance with defaultValues, added our API Secret and our Region
$config = Configuration::getDefaultConfiguration(FPJS_API_SECRET, Configuration::REGION_EUROPE);
$client = new FingerprintApi(
    new Client(),
$config
);

$visitor_id = "visitor_id_example"; // string | The [visitor ID](https://dev.fingerprint.com/reference/get-function#visitorid) you want to delete.

try {
    $client->deleteVisitorData($visitor_id);
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->deleteVisitorData: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **visitor_id** | **string**| The [visitor ID](https://dev.fingerprint.com/reference/get-function#visitorid) you want to delete. |

### Return type

Array:
0. null,
1. \Psr\Http\Message\ResponseInterface


### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getEvent**
>  [ \Fingerprint\ServerAPI\Model\EventsGetResponse, \Psr\Http\Message\ResponseInterface ] getEvent($request_id)

Get event by request ID

Get a detailed analysis of an individual identification event, including Smart Signals.  Please note that the response includes mobile signals (e.g. `rootApps`) even if the request originated from a non-mobile platform. It is highly recommended that you **ignore** the mobile signals for such requests.   Use `requestId` as the URL path parameter. This API method is scoped to a request, i.e. all returned information is by `requestId`.

### Example
```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

const FPJS_API_SECRET = "Your Fingerprint Secret API Key"; // Fingerprint Secret API Key

// Import Fingerprint Classes and Guzzle HTTP Client
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Create new Configuration instance with defaultValues, added our API Secret and our Region
$config = Configuration::getDefaultConfiguration(FPJS_API_SECRET, Configuration::REGION_EUROPE);
$client = new FingerprintApi(
    new Client(),
$config
);

$request_id = "request_id_example"; // string | The unique [identifier](https://dev.fingerprint.com/reference/get-function#requestid) of each identification request.

try {
    list($model, $httpResponse) = $client->getEvent($request_id);
    echo "<pre>" . $httpResponse->getBody()->getContents() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getEvent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **request_id** | **string**| The unique [identifier](https://dev.fingerprint.com/reference/get-function#requestid) of each identification request. |

### Return type

Array:
0. [**\Fingerprint\ServerAPI\Model\EventsGetResponse**](../Model/EventsGetResponse.md) | null,
1. \Psr\Http\Message\ResponseInterface


### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getRelatedVisitors**
>  [ \Fingerprint\ServerAPI\Model\RelatedVisitorsResponse, \Psr\Http\Message\ResponseInterface ] getRelatedVisitors($visitor_id)

Get Related Visitors

Related visitors API lets you link web visits and in-app browser visits that originated from the same mobile device. It searches the past 6 months of identification events to find the visitor IDs that belong to the same mobile device as the given visitor ID.  ⚠️ Please note that this API is not enabled by default and is billable separately. ⚠️  If you would like to use Related visitors API, please contact our [support team](https://fingerprint.com/support). To learn more, see [Related visitors API reference](https://dev.fingerprint.com/reference/related-visitors-api).

### Example
```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

const FPJS_API_SECRET = "Your Fingerprint Secret API Key"; // Fingerprint Secret API Key

// Import Fingerprint Classes and Guzzle HTTP Client
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Create new Configuration instance with defaultValues, added our API Secret and our Region
$config = Configuration::getDefaultConfiguration(FPJS_API_SECRET, Configuration::REGION_EUROPE);
$client = new FingerprintApi(
    new Client(),
$config
);

$visitor_id = "visitor_id_example"; // string | The [visitor ID](https://dev.fingerprint.com/reference/get-function#visitorid) for which you want to find the other visitor IDs that originated from the same mobile device.

try {
    list($model, $httpResponse) = $client->getRelatedVisitors($visitor_id);
    echo "<pre>" . $httpResponse->getBody()->getContents() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getRelatedVisitors: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **visitor_id** | **string**| The [visitor ID](https://dev.fingerprint.com/reference/get-function#visitorid) for which you want to find the other visitor IDs that originated from the same mobile device. |

### Return type

Array:
0. [**\Fingerprint\ServerAPI\Model\RelatedVisitorsResponse**](../Model/RelatedVisitorsResponse.md) | null,
1. \Psr\Http\Message\ResponseInterface


### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getVisits**
>  [ \Fingerprint\ServerAPI\Model\VisitorsGetResponse, \Psr\Http\Message\ResponseInterface ] getVisits($visitor_id, $request_id, $linked_id, $limit, $pagination_key, $before)

Get visits by visitor ID

Get a history of visits (identification events) for a specific `visitorId`. Use the `visitorId` as a URL path parameter. Only information from the _Identification_ product is returned.  #### Headers  * `Retry-After` — Present in case of `429 Too many requests`. Indicates how long you should wait before making a follow-up request. The value is non-negative decimal integer indicating the seconds to delay after the response is received.

### Example
```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

const FPJS_API_SECRET = "Your Fingerprint Secret API Key"; // Fingerprint Secret API Key

// Import Fingerprint Classes and Guzzle HTTP Client
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Create new Configuration instance with defaultValues, added our API Secret and our Region
$config = Configuration::getDefaultConfiguration(FPJS_API_SECRET, Configuration::REGION_EUROPE);
$client = new FingerprintApi(
    new Client(),
$config
);

$visitor_id = "visitor_id_example"; // string | Unique [visitor identifier](https://dev.fingerprint.com/reference/get-function#visitorid) issued by Fingerprint Pro.
$request_id = "request_id_example"; // string | Filter visits by `requestId`.   Every identification request has a unique identifier associated with it called `requestId`. This identifier is returned to the client in the identification [result](https://dev.fingerprint.com/reference/get-function#requestid). When you filter visits by `requestId`, only one visit will be returned.
$linked_id = "linked_id_example"; // string | Filter visits by your custom identifier.   You can use [`linkedId`](https://dev.fingerprint.com/reference/get-function#linkedid) to associate identification requests with your own identifier, for example: session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier.
$limit = 56; // int | Limit scanned results.   For performance reasons, the API first scans some number of events before filtering them. Use `limit` to specify how many events are scanned before they are filtered by `requestId` or `linkedId`. Results are always returned sorted by the timestamp (most recent first). By default, the most recent 100 visits are scanned, the maximum is 500.
$pagination_key = "pagination_key_example"; // string | Use `paginationKey` to get the next page of results.   When more results are available (e.g., you requested 200 results using `limit` parameter, but a total of 600 results are available), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `requestId` of the last returned event. In the following request, use that value in the `paginationKey` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/visitors/:visitorId?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/visitors/:visitorId?limit=200&paginationKey=1683900801733.Ogvu1j`  Pagination happens during scanning and before filtering, so you can get less visits than the `limit` you specified with more available on the next page. When there are no more results available for scanning, the `paginationKey` attribute is not returned.
$before = 789; // int | ⚠️ Deprecated pagination method, please use `paginationKey` instead. Timestamp (in milliseconds since epoch) used to paginate results.

try {
    list($model, $httpResponse) = $client->getVisits($visitor_id, request_id: $request_id, linked_id: $linked_id, limit: $limit, pagination_key: $pagination_key, before: $before);
    echo "<pre>" . $httpResponse->getBody()->getContents() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getVisits: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **visitor_id** | **string**| Unique [visitor identifier](https://dev.fingerprint.com/reference/get-function#visitorid) issued by Fingerprint Pro. |
 **request_id** | **string**| Filter visits by `requestId`.   Every identification request has a unique identifier associated with it called `requestId`. This identifier is returned to the client in the identification [result](https://dev.fingerprint.com/reference/get-function#requestid). When you filter visits by `requestId`, only one visit will be returned. | [optional]
 **linked_id** | **string**| Filter visits by your custom identifier.   You can use [`linkedId`](https://dev.fingerprint.com/reference/get-function#linkedid) to associate identification requests with your own identifier, for example: session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier. | [optional]
 **limit** | **int**| Limit scanned results.   For performance reasons, the API first scans some number of events before filtering them. Use `limit` to specify how many events are scanned before they are filtered by `requestId` or `linkedId`. Results are always returned sorted by the timestamp (most recent first). By default, the most recent 100 visits are scanned, the maximum is 500. | [optional]
 **pagination_key** | **string**| Use `paginationKey` to get the next page of results.   When more results are available (e.g., you requested 200 results using `limit` parameter, but a total of 600 results are available), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `requestId` of the last returned event. In the following request, use that value in the `paginationKey` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/visitors/:visitorId?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/visitors/:visitorId?limit=200&paginationKey=1683900801733.Ogvu1j`  Pagination happens during scanning and before filtering, so you can get less visits than the `limit` you specified with more available on the next page. When there are no more results available for scanning, the `paginationKey` attribute is not returned. | [optional]
 **before** | **int**| ⚠️ Deprecated pagination method, please use `paginationKey` instead. Timestamp (in milliseconds since epoch) used to paginate results. | [optional]

### Return type

Array:
0. [**\Fingerprint\ServerAPI\Model\VisitorsGetResponse**](../Model/VisitorsGetResponse.md) | null,
1. \Psr\Http\Message\ResponseInterface


### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **searchEvents**
>  [ \Fingerprint\ServerAPI\Model\SearchEventsResponse, \Psr\Http\Message\ResponseInterface ] searchEvents($limit, $pagination_key, $visitor_id, $bot, $ip_address, $linked_id, $start, $end, $reverse, $suspect, $vpn, $virtual_machine, $tampering, $anti_detect_browser, $incognito, $privacy_settings, $jailbroken, $frida, $factory_reset, $cloned_app, $emulator, $root_apps, $vpn_confidence, $min_suspect_score, $ip_blocklist, $datacenter, $developer_tools, $location_spoofing, $mitm_attack, $proxy, $sdk_version, $sdk_platform, $environment, $proximity_id, $proximity_precision_radius)

Get events via search

Search for identification events, including Smart Signals, using multiple filtering criteria. If you don't provide `start` or `end` parameters, the default search range is the last 7 days.  Please note that events include mobile signals (e.g. `rootApps`) even if the request originated from a non-mobile platform. We recommend you **ignore** mobile signals for such requests.

### Example
```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

const FPJS_API_SECRET = "Your Fingerprint Secret API Key"; // Fingerprint Secret API Key

// Import Fingerprint Classes and Guzzle HTTP Client
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Create new Configuration instance with defaultValues, added our API Secret and our Region
$config = Configuration::getDefaultConfiguration(FPJS_API_SECRET, Configuration::REGION_EUROPE);
$client = new FingerprintApi(
    new Client(),
$config
);

$limit = 56; // int | Limit the number of events returned.
$pagination_key = "pagination_key_example"; // string | Use `pagination_key` to get the next page of results.   When more results are available (e.g., you requested up to 200 results for your search using `limit`, but there are more than 200 events total matching your request), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `timestamp` of the last returned event. In the following request, use that value in the `pagination_key` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/events/search?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/events/search?limit=200&pagination_key=1740815825085`
$visitor_id = "visitor_id_example"; // string | Unique [visitor identifier](https://dev.fingerprint.com/reference/get-function#visitorid) issued by Fingerprint Pro. Filter for events matching this `visitor_id`.
$bot = "bot_example"; // string | Filter events by the Bot Detection result, specifically:    `all` - events where any kind of bot was detected.   `good` - events where a good bot was detected.   `bad` - events where a bad bot was detected.   `none` - events where no bot was detected. > Note: When using this parameter, only events with the `products.botd.data.bot.result` property set to a valid value are returned. Events without a `products.botd` Smart Signal result are left out of the response.
$ip_address = "ip_address_example"; // string | Filter events by IP address range. The range can be as specific as a single IP (/32 for IPv4 or /128 for IPv6)  All ip_address filters must use CIDR notation, for example, 10.0.0.0/24, 192.168.0.1/32
$linked_id = "linked_id_example"; // string | Filter events by your custom identifier.   You can use [linked IDs](https://dev.fingerprint.com/reference/get-function#linkedid) to associate identification requests with your own identifier, for example, session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier.
$start = 789; // int | Filter events with a timestamp greater than the start time, in Unix time (milliseconds).
$end = 789; // int | Filter events with a timestamp smaller than the end time, in Unix time (milliseconds).
$reverse = true; // bool | Sort events in reverse timestamp order.
$suspect = true; // bool | Filter events previously tagged as suspicious via the [Update API](https://dev.fingerprint.com/reference/updateevent).  > Note: When using this parameter, only events with the `suspect` property explicitly set to `true` or `false` are returned. Events with undefined `suspect` property are left out of the response.
$vpn = true; // bool | Filter events by VPN Detection result.   > Note: When using this parameter, only events with the `products.vpn.data.result` property set to `true` or `false` are returned. Events without a `products.vpn` Smart Signal result are left out of the response.
$virtual_machine = true; // bool | Filter events by Virtual Machine Detection result.   > Note: When using this parameter, only events with the `products.virtualMachine.data.result` property set to `true` or `false` are returned. Events without a `products.virtualMachine` Smart Signal result are left out of the response.
$tampering = true; // bool | Filter events by Tampering Detection result.   > Note: When using this parameter, only events with the `products.tampering.data.result` property set to `true` or `false` are returned. Events without a `products.tampering` Smart Signal result are left out of the response.
$anti_detect_browser = true; // bool | Filter events by Anti-detect Browser Detection result.   > Note: When using this parameter, only events with the `products.tampering.data.antiDetectBrowser` property set to `true` or `false` are returned. Events without a `products.tampering` Smart Signal result are left out of the response.
$incognito = true; // bool | Filter events by Browser Incognito Detection result.   > Note: When using this parameter, only events with the `products.incognito.data.result` property set to `true` or `false` are returned. Events without a `products.incognito` Smart Signal result are left out of the response.
$privacy_settings = true; // bool | Filter events by Privacy Settings Detection result.   > Note: When using this parameter, only events with the `products.privacySettings.data.result` property set to `true` or `false` are returned. Events without a `products.privacySettings` Smart Signal result are left out of the response.
$jailbroken = true; // bool | Filter events by Jailbroken Device Detection result.   > Note: When using this parameter, only events with the `products.jailbroken.data.result` property set to `true` or `false` are returned. Events without a `products.jailbroken` Smart Signal result are left out of the response.
$frida = true; // bool | Filter events by Frida Detection result.   > Note: When using this parameter, only events with the `products.frida.data.result` property set to `true` or `false` are returned. Events without a `products.frida` Smart Signal result are left out of the response.
$factory_reset = true; // bool | Filter events by Factory Reset Detection result.   > Note: When using this parameter, only events with the `products.factoryReset.data.result` property set to `true` or `false` are returned. Events without a `products.factoryReset` Smart Signal result are left out of the response.
$cloned_app = true; // bool | Filter events by Cloned App Detection result.   > Note: When using this parameter, only events with the `products.clonedApp.data.result` property set to `true` or `false` are returned. Events without a `products.clonedApp` Smart Signal result are left out of the response.
$emulator = true; // bool | Filter events by Android Emulator Detection result.   > Note: When using this parameter, only events with the `products.emulator.data.result` property set to `true` or `false` are returned. Events without a `products.emulator` Smart Signal result are left out of the response.
$root_apps = true; // bool | Filter events by Rooted Device Detection result.   > Note: When using this parameter, only events with the `products.rootApps.data.result` property set to `true` or `false` are returned. Events without a `products.rootApps` Smart Signal result are left out of the response.
$vpn_confidence = "vpn_confidence_example"; // string | Filter events by VPN Detection result confidence level.   `high` - events with high VPN Detection confidence. `medium` - events with medium VPN Detection confidence. `low` - events with low VPN Detection confidence. > Note: When using this parameter, only events with the `products.vpn.data.confidence` property set to a valid value are returned. Events without a `products.vpn` Smart Signal result are left out of the response.
$min_suspect_score = 3.4; // float | Filter events with Suspect Score result above a provided minimum threshold. > Note: When using this parameter, only events where the `products.suspectScore.data.result` property set to a value exceeding your threshold are returned. Events without a `products.suspectScore` Smart Signal result are left out of the response.
$ip_blocklist = true; // bool | Filter events by IP Blocklist Detection result.   > Note: When using this parameter, only events with the `products.ipBlocklist.data.result` property set to `true` or `false` are returned. Events without a `products.ipBlocklist` Smart Signal result are left out of the response.
$datacenter = true; // bool | Filter events by Datacenter Detection result.   > Note: When using this parameter, only events with the `products.ipInfo.data.v4.datacenter.result` or `products.ipInfo.data.v6.datacenter.result` property set to `true` or `false` are returned. Events without a `products.ipInfo` Smart Signal result are left out of the response.
$developer_tools = true; // bool | Filter events by Developer Tools detection result. > Note: When using this parameter, only events with the `products.developerTools.data.result` property set to `true` or `false` are returned. Events without a `products.developerTools` Smart Signal result are left out of the response.
$location_spoofing = true; // bool | Filter events by Location Spoofing detection result. > Note: When using this parameter, only events with the `products.locationSpoofing.data.result` property set to `true` or `false` are returned. Events without a `products.locationSpoofing` Smart Signal result are left out of the response.
$mitm_attack = true; // bool | Filter events by MITM (Man-in-the-Middle) Attack detection result. > Note: When using this parameter, only events with the `products.mitmAttack.data.result` property set to `true` or `false` are returned. Events without a `products.mitmAttack` Smart Signal result are left out of the response.
$proxy = true; // bool | Filter events by Proxy detection result. > Note: When using this parameter, only events with the `products.proxy.data.result` property set to `true` or `false` are returned. Events without a `products.proxy` Smart Signal result are left out of the response.
$sdk_version = "sdk_version_example"; // string | Filter events by a specific SDK version associated with the identification event. Example: `3.11.14`
$sdk_platform = "sdk_platform_example"; // string | Filter events by the SDK Platform associated with the identification event. `js` - JavaScript agent (Web). `ios` - Apple iOS based devices. `android` - Android based devices.
$environment = array("environment_example"); // string[] | Filter for events by providing one or more environment IDs.
$proximity_id = "proximity_id_example"; // string | Filter events by the most precise Proximity ID provided by default. > Note: When using this parameter, only events with the `products.proximity.id` property matching the provided ID are returned. Events without a `products.proximity` result are left out of the response.
$proximity_precision_radius = 56; // int | Filter events by Proximity Radius. > Note: When using this parameter, only events with the `products.proximity.precisionRadius` property set to a valid value are returned. Events without a `products.proximity` result are left out of the response.

try {
    list($model, $httpResponse) = $client->searchEvents($limit, pagination_key: $pagination_key, visitor_id: $visitor_id, bot: $bot, ip_address: $ip_address, linked_id: $linked_id, start: $start, end: $end, reverse: $reverse, suspect: $suspect, vpn: $vpn, virtual_machine: $virtual_machine, tampering: $tampering, anti_detect_browser: $anti_detect_browser, incognito: $incognito, privacy_settings: $privacy_settings, jailbroken: $jailbroken, frida: $frida, factory_reset: $factory_reset, cloned_app: $cloned_app, emulator: $emulator, root_apps: $root_apps, vpn_confidence: $vpn_confidence, min_suspect_score: $min_suspect_score, ip_blocklist: $ip_blocklist, datacenter: $datacenter, developer_tools: $developer_tools, location_spoofing: $location_spoofing, mitm_attack: $mitm_attack, proxy: $proxy, sdk_version: $sdk_version, sdk_platform: $sdk_platform, environment: $environment, proximity_id: $proximity_id, proximity_precision_radius: $proximity_precision_radius);
    echo "<pre>" . $httpResponse->getBody()->getContents() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->searchEvents: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **limit** | **int**| Limit the number of events returned. |
 **pagination_key** | **string**| Use `pagination_key` to get the next page of results.   When more results are available (e.g., you requested up to 200 results for your search using `limit`, but there are more than 200 events total matching your request), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `timestamp` of the last returned event. In the following request, use that value in the `pagination_key` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/events/search?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/events/search?limit=200&pagination_key=1740815825085` | [optional]
 **visitor_id** | **string**| Unique [visitor identifier](https://dev.fingerprint.com/reference/get-function#visitorid) issued by Fingerprint Pro. Filter for events matching this `visitor_id`. | [optional]
 **bot** | **string**| Filter events by the Bot Detection result, specifically:    `all` - events where any kind of bot was detected.   `good` - events where a good bot was detected.   `bad` - events where a bad bot was detected.   `none` - events where no bot was detected. > Note: When using this parameter, only events with the `products.botd.data.bot.result` property set to a valid value are returned. Events without a `products.botd` Smart Signal result are left out of the response. | [optional]
 **ip_address** | **string**| Filter events by IP address range. The range can be as specific as a single IP (/32 for IPv4 or /128 for IPv6)  All ip_address filters must use CIDR notation, for example, 10.0.0.0/24, 192.168.0.1/32 | [optional]
 **linked_id** | **string**| Filter events by your custom identifier.   You can use [linked IDs](https://dev.fingerprint.com/reference/get-function#linkedid) to associate identification requests with your own identifier, for example, session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier. | [optional]
 **start** | **int**| Filter events with a timestamp greater than the start time, in Unix time (milliseconds). | [optional]
 **end** | **int**| Filter events with a timestamp smaller than the end time, in Unix time (milliseconds). | [optional]
 **reverse** | **bool**| Sort events in reverse timestamp order. | [optional]
 **suspect** | **bool**| Filter events previously tagged as suspicious via the [Update API](https://dev.fingerprint.com/reference/updateevent).  > Note: When using this parameter, only events with the `suspect` property explicitly set to `true` or `false` are returned. Events with undefined `suspect` property are left out of the response. | [optional]
 **vpn** | **bool**| Filter events by VPN Detection result.   > Note: When using this parameter, only events with the `products.vpn.data.result` property set to `true` or `false` are returned. Events without a `products.vpn` Smart Signal result are left out of the response. | [optional]
 **virtual_machine** | **bool**| Filter events by Virtual Machine Detection result.   > Note: When using this parameter, only events with the `products.virtualMachine.data.result` property set to `true` or `false` are returned. Events without a `products.virtualMachine` Smart Signal result are left out of the response. | [optional]
 **tampering** | **bool**| Filter events by Tampering Detection result.   > Note: When using this parameter, only events with the `products.tampering.data.result` property set to `true` or `false` are returned. Events without a `products.tampering` Smart Signal result are left out of the response. | [optional]
 **anti_detect_browser** | **bool**| Filter events by Anti-detect Browser Detection result.   > Note: When using this parameter, only events with the `products.tampering.data.antiDetectBrowser` property set to `true` or `false` are returned. Events without a `products.tampering` Smart Signal result are left out of the response. | [optional]
 **incognito** | **bool**| Filter events by Browser Incognito Detection result.   > Note: When using this parameter, only events with the `products.incognito.data.result` property set to `true` or `false` are returned. Events without a `products.incognito` Smart Signal result are left out of the response. | [optional]
 **privacy_settings** | **bool**| Filter events by Privacy Settings Detection result.   > Note: When using this parameter, only events with the `products.privacySettings.data.result` property set to `true` or `false` are returned. Events without a `products.privacySettings` Smart Signal result are left out of the response. | [optional]
 **jailbroken** | **bool**| Filter events by Jailbroken Device Detection result.   > Note: When using this parameter, only events with the `products.jailbroken.data.result` property set to `true` or `false` are returned. Events without a `products.jailbroken` Smart Signal result are left out of the response. | [optional]
 **frida** | **bool**| Filter events by Frida Detection result.   > Note: When using this parameter, only events with the `products.frida.data.result` property set to `true` or `false` are returned. Events without a `products.frida` Smart Signal result are left out of the response. | [optional]
 **factory_reset** | **bool**| Filter events by Factory Reset Detection result.   > Note: When using this parameter, only events with the `products.factoryReset.data.result` property set to `true` or `false` are returned. Events without a `products.factoryReset` Smart Signal result are left out of the response. | [optional]
 **cloned_app** | **bool**| Filter events by Cloned App Detection result.   > Note: When using this parameter, only events with the `products.clonedApp.data.result` property set to `true` or `false` are returned. Events without a `products.clonedApp` Smart Signal result are left out of the response. | [optional]
 **emulator** | **bool**| Filter events by Android Emulator Detection result.   > Note: When using this parameter, only events with the `products.emulator.data.result` property set to `true` or `false` are returned. Events without a `products.emulator` Smart Signal result are left out of the response. | [optional]
 **root_apps** | **bool**| Filter events by Rooted Device Detection result.   > Note: When using this parameter, only events with the `products.rootApps.data.result` property set to `true` or `false` are returned. Events without a `products.rootApps` Smart Signal result are left out of the response. | [optional]
 **vpn_confidence** | **string**| Filter events by VPN Detection result confidence level.   `high` - events with high VPN Detection confidence. `medium` - events with medium VPN Detection confidence. `low` - events with low VPN Detection confidence. > Note: When using this parameter, only events with the `products.vpn.data.confidence` property set to a valid value are returned. Events without a `products.vpn` Smart Signal result are left out of the response. | [optional]
 **min_suspect_score** | **float**| Filter events with Suspect Score result above a provided minimum threshold. > Note: When using this parameter, only events where the `products.suspectScore.data.result` property set to a value exceeding your threshold are returned. Events without a `products.suspectScore` Smart Signal result are left out of the response. | [optional]
 **ip_blocklist** | **bool**| Filter events by IP Blocklist Detection result.   > Note: When using this parameter, only events with the `products.ipBlocklist.data.result` property set to `true` or `false` are returned. Events without a `products.ipBlocklist` Smart Signal result are left out of the response. | [optional]
 **datacenter** | **bool**| Filter events by Datacenter Detection result.   > Note: When using this parameter, only events with the `products.ipInfo.data.v4.datacenter.result` or `products.ipInfo.data.v6.datacenter.result` property set to `true` or `false` are returned. Events without a `products.ipInfo` Smart Signal result are left out of the response. | [optional]
 **developer_tools** | **bool**| Filter events by Developer Tools detection result. > Note: When using this parameter, only events with the `products.developerTools.data.result` property set to `true` or `false` are returned. Events without a `products.developerTools` Smart Signal result are left out of the response. | [optional]
 **location_spoofing** | **bool**| Filter events by Location Spoofing detection result. > Note: When using this parameter, only events with the `products.locationSpoofing.data.result` property set to `true` or `false` are returned. Events without a `products.locationSpoofing` Smart Signal result are left out of the response. | [optional]
 **mitm_attack** | **bool**| Filter events by MITM (Man-in-the-Middle) Attack detection result. > Note: When using this parameter, only events with the `products.mitmAttack.data.result` property set to `true` or `false` are returned. Events without a `products.mitmAttack` Smart Signal result are left out of the response. | [optional]
 **proxy** | **bool**| Filter events by Proxy detection result. > Note: When using this parameter, only events with the `products.proxy.data.result` property set to `true` or `false` are returned. Events without a `products.proxy` Smart Signal result are left out of the response. | [optional]
 **sdk_version** | **string**| Filter events by a specific SDK version associated with the identification event. Example: `3.11.14` | [optional]
 **sdk_platform** | **string**| Filter events by the SDK Platform associated with the identification event. `js` - JavaScript agent (Web). `ios` - Apple iOS based devices. `android` - Android based devices. | [optional]
 **environment** | [**string[]**](../Model/string.md)| Filter for events by providing one or more environment IDs. | [optional]
 **proximity_id** | **string**| Filter events by the most precise Proximity ID provided by default. > Note: When using this parameter, only events with the `products.proximity.id` property matching the provided ID are returned. Events without a `products.proximity` result are left out of the response. | [optional]
 **proximity_precision_radius** | **int**| Filter events by Proximity Radius. > Note: When using this parameter, only events with the `products.proximity.precisionRadius` property set to a valid value are returned. Events without a `products.proximity` result are left out of the response. | [optional]

### Return type

Array:
0. [**\Fingerprint\ServerAPI\Model\SearchEventsResponse**](../Model/SearchEventsResponse.md) | null,
1. \Psr\Http\Message\ResponseInterface


### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateEvent**
> updateEvent($body, $request_id)

Update an event with a given request ID

Change information in existing events specified by `requestId` or *flag suspicious events*.  When an event is created, it is assigned `linkedId` and `tag` submitted through the JS agent parameters. This information might not be available on the client so the Server API allows for updating the attributes after the fact.  **Warning** It's not possible to update events older than 10 days.

### Example
```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

const FPJS_API_SECRET = "Your Fingerprint Secret API Key"; // Fingerprint Secret API Key

// Import Fingerprint Classes and Guzzle HTTP Client
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Create new Configuration instance with defaultValues, added our API Secret and our Region
$config = Configuration::getDefaultConfiguration(FPJS_API_SECRET, Configuration::REGION_EUROPE);
$client = new FingerprintApi(
    new Client(),
$config
);

$body = new \Fingerprint\ServerAPI\Model\EventsUpdateRequest(); // \Fingerprint\ServerAPI\Model\EventsUpdateRequest | 
$request_id = "request_id_example"; // string | The unique event [identifier](https://dev.fingerprint.com/reference/get-function#requestid).

try {
    $client->updateEvent($body, $request_id);
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->updateEvent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Fingerprint\ServerAPI\Model\EventsUpdateRequest**](../Model/EventsUpdateRequest.md)|  |
 **request_id** | **string**| The unique event [identifier](https://dev.fingerprint.com/reference/get-function#requestid). |

### Return type

Array:
0. null,
1. \Psr\Http\Message\ResponseInterface


### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

