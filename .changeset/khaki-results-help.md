---
'fingerprint-pro-server-api-php-sdk': minor
---

- Make the `GeolocationCity` field `name` **required**.
- Make the `GeolocationSubdivision` field `isoCode` **required**.
- Make the `GeolocationSubdivision` field `name` **required**.
- Make the `IPInfoASN` field `name` **required** .
- Make the `IPInfoDataCenter` field `name` **required**.
- Add **optional** `IdentificationConfidence` field `comment`.
- **events**: Add **optional** `Botd` field `meta`.
- **events**: Add **optional** `Identification` field `components`.
- **events**: Make the `VPN` field `originCountry` **required**.
- **visitors**: Add **optional** `Visit` field `components`.
- **webhook**: Add **optional** `Webhook` field `components`.
