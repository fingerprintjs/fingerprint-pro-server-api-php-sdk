# VelocityIntervals
Is absent if the velocity data could not be generated for the visitor ID.



## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**_5m** | **int** |  | 
**_1h** | **int** |  | 
**_24h** | **int** | The `24h` interval of `distinctIp`, `distinctLinkedId`, `distinctCountry`, `distinctIpByLinkedId` and `distinctVisitorIdByLinkedId` will be omitted if the number of `events`` for the visitor ID in the last 24 hours (`events.intervals.['24h']`) is higher than 20.000. | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

