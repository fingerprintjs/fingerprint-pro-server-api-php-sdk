# ProxyDetails Class

Proxy detection details (present if `proxy` is `true`)

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**proxy_type** | **string** | Residential proxies use real user IP addresses to appear as legitimate traffic,  while data center proxies are public proxies hosted in data centers |
**last_seen_at** | **int** | Unix millisecond timestamp with hourly resolution of when this IP was last seen as a proxy | [optional]
**provider** | **string** | String representing the last proxy service provider detected when this IP was synced. An IP can be shared by multiple service providers. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)