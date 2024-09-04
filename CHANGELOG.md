## [5.0.0-develop.1](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v4.1.0...v5.0.0-develop.1) (2024-09-04)


### ⚠ BREAKING CHANGES

* Renamed Error Response Model Names
`ErrorEvent403ResponseError` → `Common403ErrorResponse`
`ManyRequestsResponse` → `TooManyRequestsResponse`
* Webhook `tag` field is now optional
* API Methods now throws `SerializationException`
* API Methods returns tuple instead of models
* API Methods removed other than `getModel`
* Upgraded minimum php version to 8.1
* Request logic is rewritten, Upgraded minimum php version to 8.1

### Features

* add `remoteControl`, `velocity` and `developerTools` signals ([5bf9368](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/5bf9368fb1bb5abbfa72366fe6c66fe32352ad54))
* add delete visitor data endpoint ([a00f325](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/a00f325706af38cc20e4c387db44dfa83c7a7a22))
* add retry after policy to api exception ([64e0510](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/64e05100a2c20c8d1f8e5f9719ee5292c59761c2))
* add support for validating webhook signatures inter-768 ([6a4cbd6](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/6a4cbd6e2a521a209806337d90ae8f7e291a534b))
* add update event endpoint (PUT) ([cb21d0b](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/cb21d0b4c48b7b94f4e9a7de1ab74313fe339e5f))
* change api to return tuple instead of serialized model ([62e4ad3](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/62e4ad3020425667f45e3beeb166b4095a437ab5))
* introduce rawResponse for getVisits and getEvent methods ([9b01ba6](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/9b01ba65e7ac794c77afedc155823baef2c80b17))
* introduce serialization exception ([bfea23a](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/bfea23a50b61152d4fc65d290c730d0e3fcb6123))
* only generate models and docs from swagger codegen ([26e984f](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/26e984ffd01dc9f21af3dd4da75fcb7e4309961f))
* remove raw response and introduce with http info ([ce2fedf](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/ce2fedfcd94f5f1459049ba49eff75e2d3b8620c))
* rewrite request logic ([0016822](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/001682270fd4370484b25062550a65bd375b9372))
* upgrade min php version to 8 ([5698871](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/5698871fa497ee4ad50b2941d39769b45f15dfc2))


### Bug Fixes

* serializaiton problem on sealed results ([29cb26c](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/29cb26c3f50bfa035ca750948bb92a2299f579bd))

## [4.1.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v4.0.0...v4.1.0) (2024-03-26)


### Features

* deprecate support for PHP versions older than 8.1 ([56042c3](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/56042c35eb01bf39a23000af6996204571dced6d))


### Documentation

* **README:** fix badges formatting ([779c726](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/779c726ef99166eaec006cd8467612b4e8037eeb))

## [4.0.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v3.1.0...v4.0.0) (2024-03-12)


### ⚠ BREAKING CHANGES

* change models for the most smart signals
* make identification field `confidence` optional
* deprecated `ipLocation` field uses `DeprecatedIpLocation` model

### Features

* add `linkedId` field to the `BotdResult` type ([13d1998](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/13d19989391b671d36a5b933daf64816476867f8))
* add `originCountry` field to the `vpn` signal ([d3763f9](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/d3763f97d7f4909508abdfce5cec456de42727cf))
* add `SuspectScore` smart signal support ([aad70df](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/aad70df86d2dbc76c4bf12ede7b229f9bd413b32))
* change `url` field format from URI to regular String ([425576e](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/425576ee9eb5f2f775ef075a3dc394f05d4858e8))
* fix `ipLocation` deprecation ([60c77d8](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/60c77d8f448ea5d3b469d77aca10829cb62281b2))
* make identification field `tag` required ([fbcb954](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/fbcb9547cf6dfbd03b5de00e4ae6114b9f43b06d))
* use shared structures for webhooks and event ([49480f9](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/49480f923b2bb19b6841522def6eac9aa0b64b67))


### Bug Fixes

* make fields required according to real API response ([d129f54](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/d129f54a8bad1c3df1c000b2a96337ffb90056c0))

## [3.1.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v3.0.0...v3.1.0) (2024-02-13)


### Features

* add method for decoding sealed results ([2008cf6](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/2008cf6427a1edced49aec1f2130e389622d8d88))

## [3.0.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v2.2.0...v3.0.0) (2024-01-11)


### ⚠ BREAKING CHANGES

* `IpInfo` field `data_center` renamed to `datacenter`

### Features

* deprecate `IPLocation` ([ad6201c](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/ad6201cc619cf09f74f31389eb24fe208ea1ddc4))
* use `datacenter` instead of the wrong `dataCenter` ([19158aa](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/19158aa0054c37975a83cfe0076ad48626155943))

## [2.2.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v2.1.1...v2.2.0) (2023-11-27)


### Features

* add `highActivity` and `locationSpoofing` signals, support `originTimezone` for `vpn` signal ([e35961c](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/e35961cf93a86a0e3d3ebe6d373452e3f7918853))

## [2.1.1](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v2.1.0...v2.1.1) (2023-09-19)


### Bug Fixes

* update OpenAPI Schema with `asn` and `dataCenter` signals ([36fcfe3](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/36fcfe3be5617256a43b9f809b59f0ebde166765))
* update OpenAPI Schema with `auxiliaryMobile` method for VPN signal ([ab8c25a](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/ab8c25a890a9d78b6a52cf1a784228b4702bc4a1))

## [2.1.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v2.0.0...v2.1.0) (2023-07-31)


### Features

* add raw attributes support ([d47e33a](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/d47e33a8629dda47bab1bc72ac65739c48d416ab))
* add smart signals support ([40011bb](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/40011bbd07ccdf1d99be5968c1786a8eb0be06eb))


### Bug Fixes

* generate correct code for the RawDeviceAttributes signal ([fd71960](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/fd71960ce144181cd8e8a6c1200ddd60cd098d58))

## [2.0.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v1.2.2...v2.0.0) (2023-06-06)


### ⚠ BREAKING CHANGES

* For `getVisits` method `$before` argument is deprecated
Use `$pagination_key` instead.

### Features

* update schema with correct `IpLocation` format and doc updates ([0318b55](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/0318b55599ede2e10d6ce9ec48c409d5fc605f03))

## [1.2.2](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v1.2.1...v1.2.2) (2023-05-26)


### Bug Fixes

* generate backtick symbol correctly for model documentation ([e33153c](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/e33153ca122633c61d4301fe34564687ef235768))
* update schema ([788dddb](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/788dddb6be54d570f609c920e2665cd3c704c56a))

## [1.2.1](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v1.2.0...v1.2.1) (2023-05-26)


### Bug Fixes

* update schema with improved documentation ([69c8bab](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/69c8bab9db2c7519c12eb30452bf4dc3fc578b84))
* update templates to correctly generate backtick symbol instead of html variant &#x60; ([bb7f732](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/bb7f73240c5ce00d16aa3d9d45c5f6b889326338)), closes [#x60](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/x60)

## [1.2.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v1.1.0...v1.2.0) (2023-05-16)


### Features

* update schema to introduce new signals ([cc7640a](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/cc7640a0e3af120feae7f4056fbd3db58b8bf976))

## [1.1.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v1.0.1...v1.1.0) (2023-03-01)


### Features

* **guzzle:** support laravel9 by guzzle 7.4 ([4368166](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/4368166459708cf9479bcd253b3b51563f91e439))
* **laravel:** support for 2 latest major laravel version ([e648b5e](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/e648b5ebcce050683e3a145c4f07e3381b9a0678))

## [1.1.0-develop.2](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v1.1.0-develop.1...v1.1.0-develop.2) (2023-03-01)


### Features

* **laravel:** support for 2 latest major laravel version ([e648b5e](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/e648b5ebcce050683e3a145c4f07e3381b9a0678))

## [1.1.0-develop.1](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v1.0.1...v1.1.0-develop.1) (2023-03-01)


### Features

* **guzzle:** support laravel9 by guzzle 7.4 ([4368166](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/4368166459708cf9479bcd253b3b51563f91e439))

## [1.0.1](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v1.0.0...v1.0.1) (2022-11-11)


### Documentation

* **README:** change description formatting ([dd0acbe](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/dd0acbe89d6858bf4fc26a20f5c24170c7c21eaf))
* **README:** extra information about regions ([1310806](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/1310806b2015b02e9015b84304f7efc7eac3837c))
* **README:** move tests section to bottom ([c2b0bab](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/c2b0bab528d9b202607db06be9ebb70893b9235a))

## [1.0.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.4.1...v1.0.0) (2022-11-02)


### ⚠ BREAKING CHANGES

* We now have a mature version of the sdk

### Features

* remove beta disclaimer from readme ([cb39ecd](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/cb39ecdcd8648a69971b21afdbdb7529355728c6))


### Documentation

* **README:** add packagist badges ([3aea456](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/3aea456acc7797368b2edf8292ce028dab2632c8))

## [0.4.1](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.4.0...v0.4.1) (2022-11-02)


### Documentation

* **README:** update installation instructions & introduce new tags on composer.json: ([e8e6ad6](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/e8e6ad6f5c6cf570a4c7ce121f66cef94704cbf0))

## [0.4.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.3.0...v0.4.0) (2022-11-02)


### Features

* add integration info query parameter ([e4a6c18](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/e4a6c18fa6b00ac45447e040790a6b2a7c078783))

## [0.3.0](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.2.5...v0.3.0) (2022-11-01)


### Features

* simplified configuration api ([#40](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/40)) ([0ea6edd](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/0ea6eddfbce92318f570ce496cd878676f9698b3))
* update php version for public consts & simplify docs ([#42](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/42)) ([18eb759](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/18eb759e1296dd7339cb711c02da077f359a5a0d))
* update schema to support url field for botd result ([#32](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/32)) ([002542b](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/002542b4fd667ea36ab728d1c177be314000cbae))


### Bug Fixes

* add force flag to rm command ([#33](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/33)) ([b8d8b9d](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/b8d8b9dec6c351b869fef0b50c37684ad317b6d5))
* api doc fixed for simpler use ([#43](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/43)) ([dca0952](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/dca0952e5bce0f7138e8de0da17584d6caa329d7))
* change prepareCmd command ([#36](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/36)) ([ece2766](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/ece27666ac1bff0c177858644de231dab2af6d69))
* changed readme instructions & renamed organization name ([334138c](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/334138ccac1f8d71bad86b1825a595ee6f43465a))
* posix error on releaserc ([#38](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/38)) ([6a66999](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/6a669994eb21fc0081643120917a62a79637b6b7))
* updated list of ignored generated files ([#37](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/37)) ([8fced34](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/8fced34b4157c66add3662148fc8b03adafdea6f))

## [0.3.0-develop.7](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.3.0-develop.6...v0.3.0-develop.7) (2022-11-01)


### Bug Fixes

* api doc fixed for simpler use ([#43](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/43)) ([dca0952](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/dca0952e5bce0f7138e8de0da17584d6caa329d7))

## [0.3.0-develop.6](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.3.0-develop.5...v0.3.0-develop.6) (2022-11-01)


### Features

* update php version for public consts & simplify docs ([#42](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/42)) ([18eb759](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/18eb759e1296dd7339cb711c02da077f359a5a0d))

## [0.3.0-develop.5](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.3.0-develop.4...v0.3.0-develop.5) (2022-10-31)


### Features

* simplified configuration api ([#40](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/40)) ([0ea6edd](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/0ea6eddfbce92318f570ce496cd878676f9698b3))

## [0.3.0-develop.4](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.3.0-develop.3...v0.3.0-develop.4) (2022-10-26)


### Bug Fixes

* changed readme instructions & renamed organization name ([334138c](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/334138ccac1f8d71bad86b1825a595ee6f43465a))

## [0.3.0-develop.3](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.3.0-develop.2...v0.3.0-develop.3) (2022-10-25)


### Bug Fixes

* posix error on releaserc ([#38](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/38)) ([6a66999](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/6a669994eb21fc0081643120917a62a79637b6b7))
* updated list of ignored generated files ([#37](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/37)) ([8fced34](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/8fced34b4157c66add3662148fc8b03adafdea6f))

## [0.3.0-develop.2](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.3.0-develop.1...v0.3.0-develop.2) (2022-10-25)


### Bug Fixes

* change prepareCmd command ([#36](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/36)) ([ece2766](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/ece27666ac1bff0c177858644de231dab2af6d69))

## [0.3.0-develop.1](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/compare/v0.2.5...v0.3.0-develop.1) (2022-10-25)


### Features

* update schema to support url field for botd result ([#32](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/32)) ([002542b](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/002542b4fd667ea36ab728d1c177be314000cbae))


### Bug Fixes

* add force flag to rm command ([#33](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/issues/33)) ([b8d8b9d](https://github.com/fingerprintjs/fingerprint-pro-server-api-php-sdk/commit/b8d8b9dec6c351b869fef0b50c37684ad317b6d5))
