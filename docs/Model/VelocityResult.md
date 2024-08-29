# VelocityResult
Sums key data points for a specific `visitorId` at three distinct time intervals: 5 minutes, 1 hour, and 24 hours as follows:  - Number of identification events attributed to the visitor ID - Number of distinct IP addresses associated to the visitor ID. - Number of distinct countries associated with the visitor ID. - Number of distinct `linkedId`s associated with the visitor ID. The `24h` interval of `distinctIp`, `distinctLinkedId`, and `distinctCountry` will be omitted if the number of `events` for the visitor ID in the last 24 hours (`events.intervals.['24h']`) is higher than 20.000.


## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**distinct_ip** | [**\Fingerprint\ServerAPI\Model\VelocityIntervals**](VelocityIntervals.md) |  | 
**distinct_linked_id** | [**\Fingerprint\ServerAPI\Model\VelocityIntervals**](VelocityIntervals.md) |  | 
**distinct_country** | [**\Fingerprint\ServerAPI\Model\VelocityIntervals**](VelocityIntervals.md) |  | 
**events** | [**\Fingerprint\ServerAPI\Model\VelocityIntervals**](VelocityIntervals.md) |  | 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

