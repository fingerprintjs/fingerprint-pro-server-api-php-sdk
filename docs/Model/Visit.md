# Visit

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**request_id** | **string** | Unique identifier of the user's request. | 
**browser_details** | [**\Fingerprint\ServerAPI\Model\BrowserDetails**](BrowserDetails.md) |  | 
**incognito** | **bool** | Flag if user used incognito session. | 
**ip** | **string** | IP address of the requesting browser or bot. | 
**ip_location** | [**\Fingerprint\ServerAPI\Model\DeprecatedGeolocation**](DeprecatedGeolocation.md) |  | [optional] 
**linked_id** | **string** | A customer-provided id that was sent with the request. | [optional] 
**timestamp** | **int** | Timestamp of the event with millisecond precision in Unix time. | 
**time** | [**\DateTime**](\DateTime.md) | Time expressed according to ISO 8601 in UTC format, when the request from the client agent was made. We recommend to treat requests that are older than 2 minutes as malicious. Otherwise, request replay attacks are possible. | 
**url** | **string** | Page URL from which the request was sent. | 
**tag** | array |  | 
**confidence** | [**\Fingerprint\ServerAPI\Model\IdentificationConfidence**](IdentificationConfidence.md) |  | [optional] 
**visitor_found** | **bool** | Attribute represents if a visitor had been identified before. | 
**first_seen_at** | [**\Fingerprint\ServerAPI\Model\IdentificationSeenAt**](IdentificationSeenAt.md) |  | 
**last_seen_at** | [**\Fingerprint\ServerAPI\Model\IdentificationSeenAt**](IdentificationSeenAt.md) |  | 
**components** | array |  | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

