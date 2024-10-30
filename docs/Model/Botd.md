# Botd
Contains all the information from Bot Detection product


## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**bot** | [**\Fingerprint\ServerAPI\Model\BotdBot**](BotdBot.md) |  | 
**meta** | [**\Fingerprint\ServerAPI\Model\Tag**](Tag.md) |  | [optional] 
**linked_id** | **string** | A customer-provided id that was sent with the request. | [optional] 
**url** | **string** | Page URL from which the request was sent. | 
**ip** | **string** | IP address of the requesting browser or bot. | 
**time** | [**\DateTime**](\DateTime.md) | Time in UTC when the request from the JS agent was made. We recommend to treat requests that are older than 2 minutes as malicious. Otherwise, request replay attacks are possible. | 
**user_agent** | **string** |  | 
**request_id** | **string** | Unique identifier of the user's request. | 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

