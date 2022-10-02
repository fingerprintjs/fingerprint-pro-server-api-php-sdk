# BotdResult

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**ip** | **string** | IP address of the requesting browser or bot. | 
**time** | [**\DateTime**](\DateTime.md) | Time in UTC when the request from the JS agent was made. We recommend to treat requests that are older than 2 minutes as malicious. Otherwise, request replay attacks are possible | 
**bot** | [**\Fingerprintjs\ServerAPI\Model\BotdDetectionResult**](BotdDetectionResult.md) |  | 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

