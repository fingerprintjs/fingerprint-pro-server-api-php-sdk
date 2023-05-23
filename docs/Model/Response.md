# Response

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**visitor_id** | **string** |  | 
**visits** | [**\Fingerprint\ServerAPI\Model\ResponseVisits[]**](ResponseVisits.md) |  | 
**last_timestamp** | **int** | ⚠️ Deprecated paging attribute, please use &#x60;paginationKey&#x60; instead. Timestamp of the last visit in the current page of results. | [optional] 
**pagination_key** | **string** | Request ID of the last visit in the current page of results. Use this value in the following request as the &#x60;paginationKey&#x60; parameter to get the next page of results. | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

