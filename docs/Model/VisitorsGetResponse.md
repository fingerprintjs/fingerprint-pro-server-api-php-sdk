# VisitorsGetResponse
Pagination-related fields `lastTimestamp` and `paginationKey` are included if you use a pagination parameter like `limit` or `before` and there is more data available on the next page.


## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**visitor_id** | **string** |  | 
**visits** | [**\Fingerprint\ServerAPI\Model\Visit[]**](Visit.md) |  | 
**last_timestamp** | **int** | ⚠️ Deprecated paging attribute, please use `paginationKey` instead. Timestamp of the last visit in the current page of results. | [optional] 
**pagination_key** | **string** | Request ID of the last visit in the current page of results. Use this value in the following request as the `paginationKey` parameter to get the next page of results. | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

