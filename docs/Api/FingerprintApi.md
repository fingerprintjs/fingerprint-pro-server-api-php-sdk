# Fingerprint\ServerAPI\FingerprintApi

All URIs are relative to *https://api.fpjs.io*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getEvent**](FingerprintApi.md#getevent) | **GET** /events/{request_id} | Get event by requestId
[**getVisits**](FingerprintApi.md#getvisits) | **GET** /visitors/{visitor_id} | Get visits by visitorId

# **getEvent**
> \Fingerprint\ServerAPI\Model\EventResponse getEvent($request_id)

Get event by requestId

This endpoint allows you to get a detailed analysis of an individual request.  **Only for Enterprise customers:** Please note that the response includes mobile signals (e.g. `rootApps`) even if the request originated from a non-mobile platform. It is highly recommended that you **ignore** the mobile signals for such requests.   Use `requestId` as the URL path parameter. This API method is scoped to a request, i.e. all returned information is by `requestId`.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: ApiKeyHeader
$config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()->setApiKey('Auth-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Auth-API-Key', 'Bearer');// Configure API key authorization: ApiKeyQuery
$config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()->setApiKey('api_key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api_key', 'Bearer');

$apiInstance = new Fingerprint\ServerAPI\Api\FingerprintApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$request_id = "request_id_example"; // string | The unique [identifier](https://dev.fingerprint.com/docs/js-agent#requestid) of each analysis request.

try {
    $result = $apiInstance->getEvent($request_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getEvent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **request_id** | **string**| The unique [identifier](https://dev.fingerprint.com/docs/js-agent#requestid) of each analysis request. |

### Return type

[**\Fingerprint\ServerAPI\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getVisits**
> \Fingerprint\ServerAPI\Model\Response getVisits($visitor_id, $request_id, $linked_id, $limit, $pagination_key, $before)

Get visits by visitorId

This endpoint allows you to get a history of visits for a specific `visitorId`. Use the `visitorId` as a URL path parameter. Only information from the _Identification_ product is returned.  #### Headers  * `Retry-After` — Present in case of `429 Too many requests`. Indicates how long you should wait before making a follow-up request. The value is non-negative decimal integer indicating the seconds to delay after the response is received.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: ApiKeyHeader
$config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()->setApiKey('Auth-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Auth-API-Key', 'Bearer');// Configure API key authorization: ApiKeyQuery
$config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()->setApiKey('api_key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Fingerprint\ServerAPI\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api_key', 'Bearer');

$apiInstance = new Fingerprint\ServerAPI\Api\FingerprintApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$visitor_id = "visitor_id_example"; // string | Unique identifier of the visitor issued by Fingerprint Pro.
$request_id = "request_id_example"; // string | Filter visits by `requestId`.   Every identification request has a unique identifier associated with it called `requestId`. This identifier is returned to the client in the identification [result](https://dev.fingerprint.com/docs/js-agent#requestid). When you filter visits by `requestId`, only one visit will be returned.
$linked_id = "linked_id_example"; // string | Filter visits by your custom identifier.   You can use [`linkedId`](https://dev.fingerprint.com/docs/js-agent#linkedid) to associate identification requests with your own identifier, for example: session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier.
$limit = 56; // int | Limit scanned results.   For performance reasons, the API first scans some number of events before filtering them. Use `limit` to specify how many events are scanned before they are filtered by `requestId` or `linkedId`. Results are always returned sorted by the timestamp (most recent first). By default, the most recent 100 visits are scanned, the maximum is 500.
$pagination_key = "pagination_key_example"; // string | Use `paginationKey` to get the next page of results.   When more results are available (e.g., you requested 200 results using `limit` parameter, but a total of 600 results are available), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `requestId` of the last returned event. In the following request, use that value in the `paginationKey` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/visitors/:visitorId?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/visitors/:visitorId?limit=200&paginationKey=1683900801733.Ogvu1j`  Pagination happens during scanning and before filtering, so you can get less visits than the `limit` you specified with more available on the next page. When there are no more results available for scanning, the `paginationKey` attribute is not returned.
$before = 789; // int | ⚠️ Deprecated pagination method, please use `paginationKey` instead. Timestamp (in milliseconds since epoch) used to paginate results.

try {
    $result = $apiInstance->getVisits($visitor_id, $request_id, $linked_id, $limit, $pagination_key, $before);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getVisits: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **visitor_id** | **string**| Unique identifier of the visitor issued by Fingerprint Pro. |
 **request_id** | **string**| Filter visits by &#x60;requestId&#x60;.   Every identification request has a unique identifier associated with it called &#x60;requestId&#x60;. This identifier is returned to the client in the identification [result](https://dev.fingerprint.com/docs/js-agent#requestid). When you filter visits by &#x60;requestId&#x60;, only one visit will be returned. | [optional]
 **linked_id** | **string**| Filter visits by your custom identifier.   You can use [&#x60;linkedId&#x60;](https://dev.fingerprint.com/docs/js-agent#linkedid) to associate identification requests with your own identifier, for example: session ID, purchase ID, or transaction ID. You can then use this &#x60;linked_id&#x60; parameter to retrieve all events associated with your custom identifier. | [optional]
 **limit** | **int**| Limit scanned results.   For performance reasons, the API first scans some number of events before filtering them. Use &#x60;limit&#x60; to specify how many events are scanned before they are filtered by &#x60;requestId&#x60; or &#x60;linkedId&#x60;. Results are always returned sorted by the timestamp (most recent first). By default, the most recent 100 visits are scanned, the maximum is 500. | [optional]
 **pagination_key** | **string**| Use &#x60;paginationKey&#x60; to get the next page of results.   When more results are available (e.g., you requested 200 results using &#x60;limit&#x60; parameter, but a total of 600 results are available), the &#x60;paginationKey&#x60; top-level attribute is added to the response. The key corresponds to the &#x60;requestId&#x60; of the last returned event. In the following request, use that value in the &#x60;paginationKey&#x60; parameter to get the next page of results:  1. First request, returning most recent 200 events: &#x60;GET api-base-url/visitors/:visitorId?limit&#x3D;200&#x60; 2. Use &#x60;response.paginationKey&#x60; to get the next page of results: &#x60;GET api-base-url/visitors/:visitorId?limit&#x3D;200&amp;paginationKey&#x3D;1683900801733.Ogvu1j&#x60;  Pagination happens during scanning and before filtering, so you can get less visits than the &#x60;limit&#x60; you specified with more available on the next page. When there are no more results available for scanning, the &#x60;paginationKey&#x60; attribute is not returned. | [optional]
 **before** | **int**| ⚠️ Deprecated pagination method, please use &#x60;paginationKey&#x60; instead. Timestamp (in milliseconds since epoch) used to paginate results. | [optional]

### Return type

[**\Fingerprint\ServerAPI\Model\Response**](../Model/Response.md)

### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

