# Sealed

## **UnsealEventsResponse**
> unsealEventResponse(sealed string, keys DecryptionKey[]): EventResponse

Decrypts the sealed response with provided keys.
### Required Parameters

| Name       | Type                | Description                                                                              | Notes |
|------------|---------------------|------------------------------------------------------------------------------------------|-------|
| **sealed** | **string**          | Base64 encoded sealed data                                                               |       |
| **keys**   | **DecryptionKey[]** | Decryption keys. The SDK will try to decrypt the result with each key until it succeeds. |       | 
