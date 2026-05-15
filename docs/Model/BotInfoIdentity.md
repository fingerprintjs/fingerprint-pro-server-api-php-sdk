# BotInfoIdentity Enum

The verification status of the bot's identity:
 * `verified` - well-known bot with publicly verifiable identity, directed by the bot provider.
 * `signed` - bot that signs its platform via Web Bot Auth, directed by the bot provider's customers.
 * `spoofed` - bot that claims a public identity but fails verification.
 * `unknown` - bot that does not publish a verifiable identity.


## Values

| Name | Value | Description |
| --- | --- | --- |
VERIFIED | 'verified' |  |
SIGNED | 'signed' |  |
SPOOFED | 'spoofed' |  |
UNKNOWN | 'unknown' |  |

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)