# Fingerprint\ServerAPI\FingerprintApi

All URIs are relative to *https://api.fpjs.io*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteVisitorData**](FingerprintApi.md#deleteVisitorData) | **DELETE** /visitors/{visitor_id} | Delete data by visitor ID
[**getEvent**](FingerprintApi.md#getEvent) | **GET** /events/{request_id} | Get event by request ID
[**getVisits**](FingerprintApi.md#getVisits) | **GET** /visitors/{visitor_id} | Get visits by visitor ID
[**updateEvent**](FingerprintApi.md#updateEvent) | **PUT** /events/{request_id} | Update an event with a given request ID

# **deleteVisitorData**
> deleteVisitorData($visitor_id)

Delete data by visitor ID

Request deleting all data associated with the specified visitor ID. This API is useful for compliance with privacy regulations. All delete requests are queued:   * Recent data (10 days or newer) belonging to the specified visitor will be deleted within 24 hours. * Data from older (11 days or more) identification events  will be deleted after 90 days.  If you are interested in using this API, please [contact our support team](https://fingerprint.com/support/) to enable it for you. Otherwise, you will receive a 403.

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

$visitor_id = "visitor_id_example"; // string | The [visitor ID](https://dev.fingerprint.com/docs/js-agent#visitorid) you want to delete.

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
 **visitor_id** | **string**| The [visitor ID](https://dev.fingerprint.com/docs/js-agent#visitorid) you want to delete. |

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
>  [ \Fingerprint\ServerAPI\Model\EventResponse, \Psr\Http\Message\ResponseInterface ] getEvent($request_id)

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

$request_id = "request_id_example"; // string | The unique [identifier](https://dev.fingerprint.com/docs/js-agent#requestid) of each identification request.

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
 **request_id** | **string**| The unique [identifier](https://dev.fingerprint.com/docs/js-agent#requestid) of each identification request. |

### Return type

Array:
0. [**\Fingerprint\ServerAPI\Model\EventResponse**](../Model/EventResponse.md) | null,
1. \Psr\Http\Message\ResponseInterface


### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getVisits**
>  [ \Fingerprint\ServerAPI\Model\Response, \Psr\Http\Message\ResponseInterface ] getVisits($visitor_id, $request_id, $linked_id, $limit, $pagination_key, $before)

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

$visitor_id = "visitor_id_example"; // string | Unique [visitor identifier](https://dev.fingerprint.com/docs/js-agent#visitorid) issued by Fingerprint Pro.
$request_id = "request_id_example"; // string | Filter visits by `requestId`.   Every identification request has a unique identifier associated with it called `requestId`. This identifier is returned to the client in the identification [result](https://dev.fingerprint.com/docs/js-agent#requestid). When you filter visits by `requestId`, only one visit will be returned.
$linked_id = "linked_id_example"; // string | Filter visits by your custom identifier.   You can use [`linkedId`](https://dev.fingerprint.com/docs/js-agent#linkedid) to associate identification requests with your own identifier, for example: session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier.
$limit = 56; // int | Limit scanned results.   For performance reasons, the API first scans some number of events before filtering them. Use `limit` to specify how many events are scanned before they are filtered by `requestId` or `linkedId`. Results are always returned sorted by the timestamp (most recent first). By default, the most recent 100 visits are scanned, the maximum is 500.
$pagination_key = "pagination_key_example"; // string | Use `paginationKey` to get the next page of results.   When more results are available (e.g., you requested 200 results using `limit` parameter, but a total of 600 results are available), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `requestId` of the last returned event. In the following request, use that value in the `paginationKey` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/visitors/:visitorId?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/visitors/:visitorId?limit=200&paginationKey=1683900801733.Ogvu1j`  Pagination happens during scanning and before filtering, so you can get less visits than the `limit` you specified with more available on the next page. When there are no more results available for scanning, the `paginationKey` attribute is not returned.
$before = 789; // int | ⚠️ Deprecated pagination method, please use `paginationKey` instead. Timestamp (in milliseconds since epoch) used to paginate results.

try {
    list($model, $httpResponse) = $client->getVisits($visitor_id, $request_id, $linked_id, $limit, $pagination_key, $before);
    echo "<pre>" . $httpResponse->getBody()->getContents() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getVisits: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **visitor_id** | **string**| Unique [visitor identifier](https://dev.fingerprint.com/docs/js-agent#visitorid) issued by Fingerprint Pro. |
 **request_id** | **string**| Filter visits by `requestId`.   Every identification request has a unique identifier associated with it called `requestId`. This identifier is returned to the client in the identification [result](https://dev.fingerprint.com/docs/js-agent#requestid). When you filter visits by `requestId`, only one visit will be returned. | [optional]
 **linked_id** | **string**| Filter visits by your custom identifier.   You can use [`linkedId`](https://dev.fingerprint.com/docs/js-agent#linkedid) to associate identification requests with your own identifier, for example: session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier. | [optional]
 **limit** | **int**| Limit scanned results.   For performance reasons, the API first scans some number of events before filtering them. Use `limit` to specify how many events are scanned before they are filtered by `requestId` or `linkedId`. Results are always returned sorted by the timestamp (most recent first). By default, the most recent 100 visits are scanned, the maximum is 500. | [optional]
 **pagination_key** | **string**| Use `paginationKey` to get the next page of results.   When more results are available (e.g., you requested 200 results using `limit` parameter, but a total of 600 results are available), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `requestId` of the last returned event. In the following request, use that value in the `paginationKey` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/visitors/:visitorId?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/visitors/:visitorId?limit=200&paginationKey=1683900801733.Ogvu1j`  Pagination happens during scanning and before filtering, so you can get less visits than the `limit` you specified with more available on the next page. When there are no more results available for scanning, the `paginationKey` attribute is not returned. | [optional]
 **before** | **int**| ⚠️ Deprecated pagination method, please use `paginationKey` instead. Timestamp (in milliseconds since epoch) used to paginate results. | [optional]

### Return type

Array:
0. [**\Fingerprint\ServerAPI\Model\Response**](../Model/Response.md) | null,
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

$body = new \Fingerprint\ServerAPI\Model\EventUpdateRequest(); // \Fingerprint\ServerAPI\Model\EventUpdateRequest | 
$request_id = "request_id_example"; // string | The unique event [identifier](https://dev.fingerprint.com/docs/js-agent#requestid).

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
 **body** | [**\Fingerprint\ServerAPI\Model\EventUpdateRequest**](../Model/EventUpdateRequest.md)|  |
 **request_id** | **string**| The unique event [identifier](https://dev.fingerprint.com/docs/js-agent#requestid). |

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

