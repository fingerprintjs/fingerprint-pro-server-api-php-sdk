# Fingerprint\ServerAPI\FingerprintApi

All URIs are relative to *https://api.fpjs.io*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getEvent**](FingerprintApi.md#getEvent) | **GET** /events/{request_id} | Get event by requestId
[**getVisits**](FingerprintApi.md#getVisits) | **GET** /visitors/{visitor_id} | Get visits by visitorId

# **getEvent**
> \Fingerprint\ServerAPI\Model\EventResponse getEvent($request_id)

Get event by requestId

This endpoint allows you to get events with all the information from each activated product (Fingerprint Pro or Bot Detection). Use the requestId as a URL path :request_id parameter. This API method is scoped to a request, i.e. all returned information is by requestId.

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

$request_id = "request_id_example"; // string | requestId is the unique identifier of each request

try {
    $result = $client->getEvent($request_id);
    echo "<pre>" . $response->__toString() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getEvent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **request_id** | **string**| requestId is the unique identifier of each request |

### Return type

[**\Fingerprint\ServerAPI\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getVisits**
> \Fingerprint\ServerAPI\Model\Response getVisits($visitor_id, $request_id, $linked_id, $limit, $before)

Get visits by visitorId

This endpoint allows you to get a history of visits with all available information. Use the visitorId as a URL path parameter. This API method is scoped to a visitor, i.e. all returned information is by visitorId.

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

$visitor_id = "visitor_id_example"; // string | 
$request_id = "request_id_example"; // string | Filter visits by requestId
$linked_id = "linked_id_example"; // string | Filter visits by custom identifier
$limit = 56; // int | Limit scanned results
$before = 789; // int | Timestamp (in milliseconds since epoch) used to paginate results

try {
    $result = $client->getVisits($visitor_id, $request_id, $linked_id, $limit, $before);
    echo "<pre>" . $response->__toString() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getVisits: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **visitor_id** | **string**|  |
 **request_id** | **string**| Filter visits by requestId | [optional]
 **linked_id** | **string**| Filter visits by custom identifier | [optional]
 **limit** | **int**| Limit scanned results | [optional]
 **before** | **int**| Timestamp (in milliseconds since epoch) used to paginate results | [optional]

### Return type

[**\Fingerprint\ServerAPI\Model\Response**](../Model/Response.md)

### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

