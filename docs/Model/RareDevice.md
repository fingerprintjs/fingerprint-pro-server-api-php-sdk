# RareDevice
Rare device details (present if the device is considered rare)
> This Smart Signal is currently in beta and only available to select customers. If you are interested, please [contact our support team](https://fingerprint.com/support/).



## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**result** | **bool** | `true` if the device is considered rare based on its combination of hardware and software attributes. A device is classified as rare if it falls within the top 99.9 percentile (lowest-frequency segment) of observed traffic, or if its configuration has not been previously seen (`not_seen`). | [optional] 
**percentile_bucket** | **string** | The rarity percentile bucket of the device, indicating how uncommon the device configuration is compared to all observed devices. | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

