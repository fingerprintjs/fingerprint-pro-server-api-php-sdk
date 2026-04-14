# Identification Class

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**visitor_id** | **string** | String of 20 characters that uniquely identifies the visitor&#39;s browser or mobile device. |
**confidence** | [**\Fingerprint\ServerSdk\Model\IdentificationConfidence**](IdentificationConfidence.md) |  | [optional]
**visitor_found** | **bool** | Attribute represents if a visitor had been identified before. |
**first_seen_at** | **int** | Unix epoch time milliseconds timestamp indicating the time at which this visitor ID was first seen. example: &#x60;1758069706642&#x60; - Corresponding to Wed Sep 17 2025 00:41:46 GMT+0000 | [optional]
**last_seen_at** | **int** | Unix epoch time milliseconds timestamp indicating the time at which this visitor ID was last seen. example: &#x60;1758069706642&#x60; - Corresponding to Wed Sep 17 2025 00:41:46 GMT+0000 | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)