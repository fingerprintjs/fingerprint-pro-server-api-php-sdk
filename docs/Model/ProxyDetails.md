# ProxyDetails Class

Proxy detection details (present if `proxy` is `true`)

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**proxy_type** | **string** | Proxy type:  * &#x60;residential&#x60; - proxies that route through residential and telecom IP addresses to appear as legitimate traffic  * &#x60;data_center&#x60; - proxies which route through data centers  * &#x60;unknown&#x60; - reported when a proxy is detected solely by the ML model and the IP sources did not determine a specific type |
**last_seen_at** | **int** | Unix millisecond timestamp with hourly resolution of when this IP was last seen as a proxy | [optional]
**provider** | **string** | String representing the last proxy service provider detected when this IP was synced. An IP can be shared by multiple service providers. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)