# TamperingDetails Class

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**anomaly_score** | **float** | Confidence score (&#x60;0.0 - 1.0&#x60;) for tampering detection:   * Values above &#x60;0.5&#x60; indicate tampering.   * Values below &#x60;0.5&#x60; indicate genuine browsers. | [optional]
**anti_detect_browser** | **bool** | True if the identified browser resembles an \&quot;anti-detect\&quot; browser, such as Incognition, which attempts to evade identification by manipulating its fingerprint. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)