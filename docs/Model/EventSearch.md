# EventSearch Class

Contains a list of all identification events matching the specified search criteria.

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**events** | [**\Fingerprint\ServerSdk\Model\Event[]**](Event.md) |  |
**pagination_key** | **string** | Use this value in the &#x60;pagination_key&#x60; parameter to request the next page of search results. | [optional]
**total_hits** | **int** | This value represents the total number of events matching the search query, up to the limit provided in the &#x60;total_hits&#x60; query parameter. Only present if the &#x60;total_hits&#x60; query parameter was provided. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)