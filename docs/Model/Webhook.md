# Webhook

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**request_id** | **string** | Unique identifier of the user's request. | 
**url** | **string** | Page URL from which the request was sent. | 
**ip** | **string** | IP address of the requesting browser or bot. | 
**environment_id** | **string** | Environment ID of the event. | [optional] 
**tag** | array |  | [optional] 
**time** | [**\DateTime**](\DateTime.md) | Time expressed according to ISO 8601 in UTC format, when the request from the JS agent was made. We recommend to treat requests that are older than 2 minutes as malicious. Otherwise, request replay attacks are possible. | 
**timestamp** | **int** | Timestamp of the event with millisecond precision in Unix time. | 
**ip_location** | [**\Fingerprint\ServerAPI\Model\DeprecatedGeolocation**](DeprecatedGeolocation.md) |  | [optional] 
**linked_id** | **string** | A customer-provided id that was sent with the request. | [optional] 
**visitor_id** | **string** | String of 20 characters that uniquely identifies the visitor's browser. | [optional] 
**visitor_found** | **bool** | Attribute represents if a visitor had been identified before. | [optional] 
**confidence** | [**\Fingerprint\ServerAPI\Model\IdentificationConfidence**](IdentificationConfidence.md) |  | [optional] 
**first_seen_at** | [**\Fingerprint\ServerAPI\Model\IdentificationSeenAt**](IdentificationSeenAt.md) |  | [optional] 
**last_seen_at** | [**\Fingerprint\ServerAPI\Model\IdentificationSeenAt**](IdentificationSeenAt.md) |  | [optional] 
**browser_details** | [**\Fingerprint\ServerAPI\Model\BrowserDetails**](BrowserDetails.md) |  | [optional] 
**incognito** | **bool** | Flag if user used incognito session. | [optional] 
**client_referrer** | **string** |  | [optional] 
**components** | array |  | [optional] 
**bot** | [**\Fingerprint\ServerAPI\Model\BotdBot**](BotdBot.md) |  | [optional] 
**user_agent** | **string** |  | [optional] 
**root_apps** | [**\Fingerprint\ServerAPI\Model\WebhookRootApps**](WebhookRootApps.md) |  | [optional] 
**emulator** | [**\Fingerprint\ServerAPI\Model\WebhookEmulator**](WebhookEmulator.md) |  | [optional] 
**ip_info** | [**\Fingerprint\ServerAPI\Model\WebhookIPInfo**](WebhookIPInfo.md) |  | [optional] 
**ip_blocklist** | [**\Fingerprint\ServerAPI\Model\WebhookIPBlocklist**](WebhookIPBlocklist.md) |  | [optional] 
**tor** | [**\Fingerprint\ServerAPI\Model\WebhookTor**](WebhookTor.md) |  | [optional] 
**vpn** | [**\Fingerprint\ServerAPI\Model\WebhookVPN**](WebhookVPN.md) |  | [optional] 
**proxy** | [**\Fingerprint\ServerAPI\Model\WebhookProxy**](WebhookProxy.md) |  | [optional] 
**tampering** | [**\Fingerprint\ServerAPI\Model\WebhookTampering**](WebhookTampering.md) |  | [optional] 
**cloned_app** | [**\Fingerprint\ServerAPI\Model\WebhookClonedApp**](WebhookClonedApp.md) |  | [optional] 
**factory_reset** | [**\Fingerprint\ServerAPI\Model\WebhookFactoryReset**](WebhookFactoryReset.md) |  | [optional] 
**jailbroken** | [**\Fingerprint\ServerAPI\Model\WebhookJailbroken**](WebhookJailbroken.md) |  | [optional] 
**frida** | [**\Fingerprint\ServerAPI\Model\WebhookFrida**](WebhookFrida.md) |  | [optional] 
**privacy_settings** | [**\Fingerprint\ServerAPI\Model\WebhookPrivacySettings**](WebhookPrivacySettings.md) |  | [optional] 
**virtual_machine** | [**\Fingerprint\ServerAPI\Model\WebhookVirtualMachine**](WebhookVirtualMachine.md) |  | [optional] 
**raw_device_attributes** | array |  | [optional] 
**high_activity** | [**\Fingerprint\ServerAPI\Model\WebhookHighActivity**](WebhookHighActivity.md) |  | [optional] 
**location_spoofing** | [**\Fingerprint\ServerAPI\Model\WebhookLocationSpoofing**](WebhookLocationSpoofing.md) |  | [optional] 
**suspect_score** | [**\Fingerprint\ServerAPI\Model\WebhookSuspectScore**](WebhookSuspectScore.md) |  | [optional] 
**remote_control** | [**\Fingerprint\ServerAPI\Model\WebhookRemoteControl**](WebhookRemoteControl.md) |  | [optional] 
**velocity** | [**\Fingerprint\ServerAPI\Model\WebhookVelocity**](WebhookVelocity.md) |  | [optional] 
**developer_tools** | [**\Fingerprint\ServerAPI\Model\WebhookDeveloperTools**](WebhookDeveloperTools.md) |  | [optional] 
**mitm_attack** | [**\Fingerprint\ServerAPI\Model\WebhookMitMAttack**](WebhookMitMAttack.md) |  | [optional] 
**replayed** | **bool** | `true` if we determined that this payload was replayed, `false` otherwise. | [optional] 
**sdk** | [**\Fingerprint\ServerAPI\Model\SDK**](SDK.md) |  | 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

