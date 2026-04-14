# SearchEventsBot Enum

Filter events by the Bot Detection result, specifically:
  `all` - events where any kind of bot was detected.
  `good` - events where a good bot was detected.
  `bad` - events where a bad bot was detected.
  `none` - events where no bot was detected.
> Note: When using this parameter, only events with the `bot` property set to a valid value are returned. Events without a `bot` Smart Signal result are left out of the response.


## Values

| Name | Value | Description |
| --- | --- | --- |
ALL | 'all' |  |
GOOD | 'good' |  |
BAD | 'bad' |  |
NONE | 'none' |  |

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)