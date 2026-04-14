# EventRuleAction Class

Describes the action the client should take, according to the rule in the ruleset that matched the event. When getting an event by event ID, the rule_action will only be included when the ruleset_id query parameter is specified.

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**ruleset_id** | **string** | The ID of the evaluated ruleset. |
**rule_id** | **string** | The ID of the rule that matched the identification event. | [optional]
**rule_expression** | **string** | The expression of the rule that matched the identification event. | [optional]
**type** | [**\Fingerprint\ServerSdk\Model\RuleActionType**](RuleActionType.md) |  |
**request_header_modifications** | [**\Fingerprint\ServerSdk\Model\RequestHeaderModifications**](RequestHeaderModifications.md) |  | [optional]
**status_code** | **int** | A valid HTTP status code. | [optional]
**headers** | [**\Fingerprint\ServerSdk\Model\RuleActionHeaderField[]**](RuleActionHeaderField.md) | A list of headers to send. | [optional]
**body** | **string** | The response body to send to the client. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)