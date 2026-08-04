# VPN

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**result** | **bool** | VPN or other anonymizing service has been used when sending the request. | 
**confidence** | [**\Fingerprint\ServerAPI\Model\VPNConfidence**](VPNConfidence.md) |  | 
**ml_score** | **double** | Machine learning–based VPN score, represented as a floating-point value between 0 and 1 (inclusive), with up to three decimal places of precision. A higher score means a higher confidence in the positive `vpn` detection result. This Smart Signal is currently in beta and only available to select customers. If you are interested, please [contact our support team](https://fingerprint.com/support/). | [optional] 
**origin_timezone** | **string** | Local timezone which is used in timezoneMismatch method. | 
**origin_country** | **string** | Country of the request (only for Android SDK version >= 2.4.0, ISO 3166 format or unknown). | 
**methods** | [**\Fingerprint\ServerAPI\Model\VPNMethods**](VPNMethods.md) |  | 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

