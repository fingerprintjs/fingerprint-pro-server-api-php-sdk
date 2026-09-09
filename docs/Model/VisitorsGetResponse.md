# VisitorsGetResponse
Deprecated response shape for `GET /visitors/{visitor_id}`. The `visits` array currently contains at most one item. Use `GET /events/search` for multi-event history and filtering.


## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**visitor_id** | **string** |  | 
**visits** | [**\Fingerprint\ServerAPI\Model\Visit[]**](Visit.md) |  | 
**last_timestamp** | **int** | ⚠️ Deprecated paging attribute, please use `paginationKey` instead. Timestamp of the last visit in the current page of results. | [optional] 
**pagination_key** | **string** | Use this value in the following request as the `paginationKey` parameter to get the next result. | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

