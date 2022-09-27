# Fingerprintjs\ServerAPI\FingerprintApi

All URIs are relative to *https://api.fpjs.io*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getEvent**](FingerprintApi.md#getevent) | **GET** /events/{request_id} | Get event by request ID
[**getVisits**](FingerprintApi.md#getvisits) | **GET** /visitors/{visitor_id} | 

# **getEvent**
> \Fingerprintjs\ServerAPI\Model\EventResponse getEvent($request_id)

Get event by request ID

This endpoint allows you to get events with all the information from each activated product - BOTD and Fingerprinting. Use the requestId as a URL path :request_id parameter. This API method is scoped to a request, i.e. all returned information is by requestId.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: ApiKeyHeader
$config = Fingerprintjs\ServerAPI\Configuration::getDefaultConfiguration()->setApiKey('Auth-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Fingerprintjs\ServerAPI\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Auth-API-Key', 'Bearer');// Configure API key authorization: ApiKeyQuery
$config = Fingerprintjs\ServerAPI\Configuration::getDefaultConfiguration()->setApiKey('api_key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Fingerprintjs\ServerAPI\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api_key', 'Bearer');

$apiInstance = new Fingerprintjs\ServerAPI\Api\FingerprintApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$request_id = "request_id_example"; // string | Request ID

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
 **request_id** | **string**| Request ID |

### Return type

[**\Fingerprintjs\ServerAPI\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getVisits**
> \Fingerprintjs\ServerAPI\Model\Response getVisits($visitor_id, $request_id, $linked_id, $limit, $before)



This endpoint allows you to get a history of visits with all available information. Use the visitorId as a URL path parameter. This API method is scoped to a visitor, i.e. all returned information is by visitorId.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: ApiKeyHeader
$config = Fingerprintjs\ServerAPI\Configuration::getDefaultConfiguration()->setApiKey('Auth-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Fingerprintjs\ServerAPI\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Auth-API-Key', 'Bearer');// Configure API key authorization: ApiKeyQuery
$config = Fingerprintjs\ServerAPI\Configuration::getDefaultConfiguration()->setApiKey('api_key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Fingerprintjs\ServerAPI\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api_key', 'Bearer');

$apiInstance = new Fingerprintjs\ServerAPI\Api\FingerprintApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$visitor_id = "visitor_id_example"; // string | 
$request_id = "request_id_example"; // string | Filter events by requestId
$linked_id = "linked_id_example"; // string | Filter events by custom identifier
$limit = 56; // int | Limit scanned results
$before = 56; // int | Used to paginate results

try {
    $result = $apiInstance->getVisits($visitor_id, $request_id, $linked_id, $limit, $before);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getVisits: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **visitor_id** | **string**|  |
 **request_id** | **string**| Filter events by requestId | [optional]
 **linked_id** | **string**| Filter events by custom identifier | [optional]
 **limit** | **int**| Limit scanned results | [optional]
 **before** | **int**| Used to paginate results | [optional]

### Return type

[**\Fingerprintjs\ServerAPI\Model\Response**](../Model/Response.md)

### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

