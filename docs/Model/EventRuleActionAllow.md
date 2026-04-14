# EventRuleActionAllow Class

Informs the client that the request should be forwarded to the origin with optional request header modifications.

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**ruleset_id** | **string** | The ID of the evaluated ruleset. |
**rule_id** | **string** | The ID of the rule that matched the identification event. | [optional]
**rule_expression** | **string** | The expression of the rule that matched the identification event. | [optional]
**type** | [**\Fingerprint\ServerSdk\Model\RuleActionType**](RuleActionType.md) |  |
**request_header_modifications** | [**\Fingerprint\ServerSdk\Model\RequestHeaderModifications**](RequestHeaderModifications.md) |  | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)