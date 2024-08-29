# FactoryResetResult

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**time** | [**\DateTime**](\DateTime.md) | Indicates the time (in UTC) of the most recent factory reset that happened on the **mobile device**.  When a factory reset cannot be detected on the mobile device or when the request is initiated from a browser, this field will correspond to the *epoch* time (i.e 1 Jan 1970 UTC). See [Factory Reset Detection](https://dev.fingerprint.com/docs/smart-signals-overview#factory-reset-detection) to learn more about this Smart Signal. | 
**timestamp** | **int** | This field is just another representation of the value in the `time` field. The time of the most recent factory reset that happened on the **mobile device** is expressed as Unix epoch time. | 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

