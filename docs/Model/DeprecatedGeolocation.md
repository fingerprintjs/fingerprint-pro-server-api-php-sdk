# DeprecatedGeolocation
This field is **deprecated** and will not return a result for **applications created after January 23rd, 2024**.  Please use the [IP Geolocation Smart signal](https://dev.fingerprint.com/docs/smart-signals-overview#ip-geolocation) for geolocation information.


## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**accuracy_radius** | **int** | The IP address is likely to be within this radius (in km) of the specified location. | [optional] 
**latitude** | **double** |  | [optional] 
**longitude** | **double** |  | [optional] 
**postal_code** | **string** |  | [optional] 
**timezone** | **string** |  | [optional] 
**city** | [**\Fingerprint\ServerAPI\Model\GeolocationCity**](GeolocationCity.md) |  | [optional] 
**country** | [**\Fingerprint\ServerAPI\Model\GeolocationCountry**](GeolocationCountry.md) |  | [optional] 
**continent** | [**\Fingerprint\ServerAPI\Model\GeolocationContinent**](GeolocationContinent.md) |  | [optional] 
**subdivisions** | array |  | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

