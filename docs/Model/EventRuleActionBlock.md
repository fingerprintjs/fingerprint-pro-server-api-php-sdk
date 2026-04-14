# EventRuleActionBlock Class

Informs the client the request should be blocked using the response described by this rule action.

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**ruleset_id** | **string** | The ID of the evaluated ruleset. |
**rule_id** | **string** | The ID of the rule that matched the identification event. | [optional]
**rule_expression** | **string** | The expression of the rule that matched the identification event. | [optional]
**type** | [**\Fingerprint\ServerSdk\Model\RuleActionType**](RuleActionType.md) |  |
**status_code** | **int** | A valid HTTP status code. | [optional]
**headers** | [**\Fingerprint\ServerSdk\Model\RuleActionHeaderField[]**](RuleActionHeaderField.md) | A list of headers to send. | [optional]
**body** | **string** | The response body to send to the client. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)