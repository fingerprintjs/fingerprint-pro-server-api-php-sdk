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
**ip_location** | [**\Fingerprint\ServerSdk\Model\DeprecatedGeolocation**](DeprecatedGeolocation.md) |  | [optional] 
**linked_id** | **string** | A customer-provided id that was sent with the request. | [optional] 
**visitor_id** | **string** | String of 20 characters that uniquely identifies the visitor's browser or mobile device. | [optional] 
**visitor_found** | **bool** | Attribute represents if a visitor had been identified before. | [optional] 
**confidence** | [**\Fingerprint\ServerSdk\Model\IdentificationConfidence**](IdentificationConfidence.md) |  | [optional] 
**first_seen_at** | [**\Fingerprint\ServerSdk\Model\IdentificationSeenAt**](IdentificationSeenAt.md) |  | [optional] 
**last_seen_at** | [**\Fingerprint\ServerSdk\Model\IdentificationSeenAt**](IdentificationSeenAt.md) |  | [optional] 
**browser_details** | [**\Fingerprint\ServerSdk\Model\BrowserDetails**](BrowserDetails.md) |  | [optional] 
**incognito** | **bool** | Flag if user used incognito session. | [optional] 
**client_referrer** | **string** |  | [optional] 
**components** | array |  | [optional] 
**bot** | [**\Fingerprint\ServerSdk\Model\BotdBot**](BotdBot.md) |  | [optional] 
**user_agent** | **string** |  | [optional] 
**root_apps** | [**\Fingerprint\ServerSdk\Model\WebhookRootApps**](WebhookRootApps.md) |  | [optional] 
**emulator** | [**\Fingerprint\ServerSdk\Model\WebhookEmulator**](WebhookEmulator.md) |  | [optional] 
**ip_info** | [**\Fingerprint\ServerSdk\Model\WebhookIPInfo**](WebhookIPInfo.md) |  | [optional] 
**ip_blocklist** | [**\Fingerprint\ServerSdk\Model\WebhookIPBlocklist**](WebhookIPBlocklist.md) |  | [optional] 
**tor** | [**\Fingerprint\ServerSdk\Model\WebhookTor**](WebhookTor.md) |  | [optional] 
**vpn** | [**\Fingerprint\ServerSdk\Model\WebhookVPN**](WebhookVPN.md) |  | [optional] 
**proxy** | [**\Fingerprint\ServerSdk\Model\WebhookProxy**](WebhookProxy.md) |  | [optional] 
**tampering** | [**\Fingerprint\ServerSdk\Model\WebhookTampering**](WebhookTampering.md) |  | [optional] 
**cloned_app** | [**\Fingerprint\ServerSdk\Model\WebhookClonedApp**](WebhookClonedApp.md) |  | [optional] 
**factory_reset** | [**\Fingerprint\ServerSdk\Model\WebhookFactoryReset**](WebhookFactoryReset.md) |  | [optional] 
**jailbroken** | [**\Fingerprint\ServerSdk\Model\WebhookJailbroken**](WebhookJailbroken.md) |  | [optional] 
**frida** | [**\Fingerprint\ServerSdk\Model\WebhookFrida**](WebhookFrida.md) |  | [optional] 
**privacy_settings** | [**\Fingerprint\ServerSdk\Model\WebhookPrivacySettings**](WebhookPrivacySettings.md) |  | [optional] 
**virtual_machine** | [**\Fingerprint\ServerSdk\Model\WebhookVirtualMachine**](WebhookVirtualMachine.md) |  | [optional] 
**raw_device_attributes** | array |  | [optional] 
**high_activity** | [**\Fingerprint\ServerSdk\Model\WebhookHighActivity**](WebhookHighActivity.md) |  | [optional] 
**location_spoofing** | [**\Fingerprint\ServerSdk\Model\WebhookLocationSpoofing**](WebhookLocationSpoofing.md) |  | [optional] 
**suspect_score** | [**\Fingerprint\ServerSdk\Model\WebhookSuspectScore**](WebhookSuspectScore.md) |  | [optional] 
**remote_control** | [**\Fingerprint\ServerSdk\Model\WebhookRemoteControl**](WebhookRemoteControl.md) |  | [optional] 
**velocity** | [**\Fingerprint\ServerSdk\Model\WebhookVelocity**](WebhookVelocity.md) |  | [optional] 
**developer_tools** | [**\Fingerprint\ServerSdk\Model\WebhookDeveloperTools**](WebhookDeveloperTools.md) |  | [optional] 
**mitm_attack** | [**\Fingerprint\ServerSdk\Model\WebhookMitMAttack**](WebhookMitMAttack.md) |  | [optional] 
**replayed** | **bool** | `true` if we determined that this payload was replayed, `false` otherwise. | [optional] 
**sdk** | [**\Fingerprint\ServerSdk\Model\SDK**](SDK.md) |  | 
**supplementary_ids** | [**\Fingerprint\ServerSdk\Model\WebhookSupplementaryIDs**](WebhookSupplementaryIDs.md) |  | [optional] 
**proximity** | [**\Fingerprint\ServerSdk\Model\WebhookProximity**](WebhookProximity.md) |  | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

