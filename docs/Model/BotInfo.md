# BotInfo Class

Extended bot information.

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**category** | **string** | The type and purpose of the bot. |
**provider** | **string** | The organization or company operating the bot. |
**provider_url** | **string** | The URL of the bot provider&#39;s website. | [optional]
**name** | **string** | The specific name or identifier of the bot. |
**identity** | **string** | The verification status of the bot&#39;s identity:  * &#x60;verified&#x60; - well-known bot with publicly verifiable identity, directed by the bot provider.  * &#x60;signed&#x60; - bot that signs its platform via Web Bot Auth, directed by the bot provider’s customers.  * &#x60;spoofed&#x60; - bot that claims a public identity but fails verification.  * &#x60;unknown&#x60; - bot that does not publish a verifiable identity. |
**confidence** | **string** | Confidence level of the bot identification. |

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)