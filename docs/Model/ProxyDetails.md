# ProxyDetails
Proxy detection details (present if proxy is detected)


## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**proxy_type** | **string** | Proxy type:  * `residential` - proxies that route through residential and telecom IP addresses to appear as legitimate traffic  * `data_center` - proxies which route through data centers  * `unknown` - reported when a proxy is detected solely by the ML model and the IP sources did not determine a specific type | 
**last_seen_at** | [**\DateTime**](\DateTime.md) | ISO 8601 formatted timestamp in UTC with hourly resolution of when this IP was last seen as a proxy when available. | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

