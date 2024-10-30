# WebhookVPN

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**result** | **bool** | VPN or other anonymizing service has been used when sending the request. | [optional] 
**confidence** | [**\Fingerprint\ServerAPI\Model\VPNConfidence**](VPNConfidence.md) |  | [optional] 
**origin_timezone** | **string** | Local timezone which is used in timezoneMismatch method. | [optional] 
**origin_country** | **string** | Country of the request (only for Android SDK version >= 2.4.0, ISO 3166 format or unknown). | [optional] 
**methods** | [**\Fingerprint\ServerAPI\Model\VPNMethods**](VPNMethods.md) |  | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

