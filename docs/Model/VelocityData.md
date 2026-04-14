# VelocityData Class

Is absent if the velocity data could not be generated for the visitor Id.


## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**_5_minutes** | **int** | Count for the last 5 minutes of velocity data, from the time of the event. |
**_1_hour** | **int** | Count for the last 1 hour of velocity data, from the time of the event. |
**_24_hours** | **int** | The &#x60;24_hours&#x60; interval of &#x60;distinct_ip&#x60;, &#x60;distinct_linked_id&#x60;, &#x60;distinct_country&#x60;, &#x60;distinct_ip_by_linked_id&#x60; and &#x60;distinct_visitor_id_by_linked_id&#x60; will be omitted if the number of &#x60;events&#x60; for the visitor Id in the last 24 hours (&#x60;events.[&#39;24_hours&#39;]&#x60;) is higher than 20.000. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)