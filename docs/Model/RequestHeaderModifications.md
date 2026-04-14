# RequestHeaderModifications Class

The set of header modifications to apply, in the following order: remove, set, append.

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**remove** | **string[]** | The list of headers to remove. | [optional]
**set** | [**\Fingerprint\ServerSdk\Model\RuleActionHeaderField[]**](RuleActionHeaderField.md) | The list of headers to set, overwriting any existing headers with the same name. | [optional]
**append** | [**\Fingerprint\ServerSdk\Model\RuleActionHeaderField[]**](RuleActionHeaderField.md) | The list of headers to append. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)