# Proximity Class

Proximity ID represents a fixed geographical zone in a discrete global grid within which the device is observed.


## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | A stable privacy-preserving identifier for a given proximity zone. |
**precision_radius** | **int** | The radius of the proximity zone’s precision level, in meters. |
**confidence** | **float** | A value between &#x60;0&#x60; and &#x60;1&#x60; representing the likelihood that the true device location lies within the mapped proximity zone.   * Scores closer to &#x60;1&#x60; indicate high confidence that the location is inside the mapped proximity zone.   * Scores closer to &#x60;0&#x60; indicate lower confidence, suggesting the true location may fall in an adjacent zone. |

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)