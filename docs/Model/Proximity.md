# Proximity
Proximity ID represents a fixed geographical zone in a discrete global grid within which the device is observed.



## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | A stable privacy-preserving identifier for a given proximity zone. | 
**precision_radius** | **int** | The radius of the proximity zone’s precision level, in meters. | 
**confidence** | **float** | A value between `0` and `1` representing the likelihood that the true device location lies within the mapped proximity zone.   * Scores closer to `1` indicate high confidence that the location is inside the mapped proximity zone.   * Scores closer to `0` indicate lower confidence, suggesting the true location may fall in an adjacent zone. | 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

