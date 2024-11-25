<?php
/**
 * WebhookVPN.
 *
 * @category Class
 *
 * @author   Swagger Codegen team
 *
 * @see     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Fingerprint Pro Server API.
 *
 * Fingerprint Pro Server API allows you to get information about visitors and about individual events in a server environment. It can be used for data exports, decision-making, and data analysis scenarios. Server API is intended for server-side usage, it's not intended to be used from the client side, whether it's a browser or a mobile device.
 *
 * OpenAPI spec version: 3
 * Contact: support@fingerprint.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.34
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Fingerprint\ServerAPI\Model;

use Fingerprint\ServerAPI\ObjectSerializer;

/**
 * WebhookVPN Class Doc Comment.
 *
 * @category Class
 *
 * @author   Swagger Codegen team
 *
 * @see     https://github.com/swagger-api/swagger-codegen
 */
class WebhookVPN implements ModelInterface, \ArrayAccess
{
    /**
     * The original name of the model.
     *
     */
    protected static string $swaggerModelName = 'WebhookVPN';

    /**
     * Array of property to type mappings. Used for (de)serialization.
     *
     * @var string[]
     */
    protected static array $swaggerTypes = [
        'result' => 'bool',
        'confidence' => '\Fingerprint\ServerAPI\Model\VPNConfidence',
        'origin_timezone' => 'string',
        'origin_country' => 'string',
        'methods' => '\Fingerprint\ServerAPI\Model\VPNMethods'];

    /**
     * Array of property to format mappings. Used for (de)serialization.
     *
     * @var string[]
     */
    protected static array $swaggerFormats = [
        'result' => null,
        'confidence' => null,
        'origin_timezone' => null,
        'origin_country' => null,
        'methods' => null];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name.
     *
     * @var string[]
     */
    protected static array $attributeMap = [
        'result' => 'result',
        'confidence' => 'confidence',
        'origin_timezone' => 'originTimezone',
        'origin_country' => 'originCountry',
        'methods' => 'methods'];

    /**
     * Array of attributes to setter functions (for deserialization of responses).
     *
     * @var string[]
     */
    protected static array $setters = [
        'result' => 'setResult',
        'confidence' => 'setConfidence',
        'origin_timezone' => 'setOriginTimezone',
        'origin_country' => 'setOriginCountry',
        'methods' => 'setMethods'];

    /**
     * Array of attributes to getter functions (for serialization of requests).
     *
     * @var string[]
     */
    protected static array $getters = [
        'result' => 'getResult',
        'confidence' => 'getConfidence',
        'origin_timezone' => 'getOriginTimezone',
        'origin_country' => 'getOriginCountry',
        'methods' => 'getMethods'];

    /**
     * Associative array for storing property values.
     *
     * @var mixed[]
     */
    protected array $container = [];

    /**
     * Constructor.
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(?array $data = null)
    {
        $this->container['result'] = isset($data['result']) ? $data['result'] : null;
        $this->container['confidence'] = isset($data['confidence']) ? $data['confidence'] : null;
        $this->container['origin_timezone'] = isset($data['origin_timezone']) ? $data['origin_timezone'] : null;
        $this->container['origin_country'] = isset($data['origin_country']) ? $data['origin_country'] : null;
        $this->container['methods'] = isset($data['methods']) ? $data['methods'] : null;
    }

    /**
     * Gets the string presentation of the object.
     *
     */
    public function __toString(): string
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }

    /**
     * Array of property to type mappings. Used for (de)serialization.
     */
    public static function swaggerTypes(): array
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization.
     */
    public static function swaggerFormats(): array
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name.
     */
    public static function attributeMap(): array
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses).
     */
    public static function setters(): array
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests).
     */
    public static function getters(): array
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     */
    public function getModelName(): string
    {
        return self::$swaggerModelName;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties(): array
    {
        return [];
    }

    /**
     * Validate all the properties in the model
     * return true if all passed.
     *
     * @return bool True if all properties are valid
     */
    public function valid(): bool
    {
        return 0 === count($this->listInvalidProperties());
    }

    /**
     * Gets result.
     */
    public function getResult(): ?bool
    {
        return $this->container['result'];
    }

    /**
     * Sets result.
     *
     * @param ?bool $result VPN or other anonymizing service has been used when sending the request
     *
     * @return $this
     */
    public function setResult(?bool $result): self
    {
        $this->container['result'] = $result;

        return $this;
    }

    /**
     * Gets confidence.
     */
    public function getConfidence(): ?VPNConfidence
    {
        return $this->container['confidence'];
    }

    /**
     * Sets confidence.
     *
     * @param ?\Fingerprint\ServerAPI\Model\VPNConfidence $confidence confidence
     *
     * @return $this
     */
    public function setConfidence(?VPNConfidence $confidence): self
    {
        $this->container['confidence'] = $confidence;

        return $this;
    }

    /**
     * Gets origin_timezone.
     */
    public function getOriginTimezone(): ?string
    {
        return $this->container['origin_timezone'];
    }

    /**
     * Sets origin_timezone.
     *
     * @param ?string $origin_timezone local timezone which is used in timezoneMismatch method
     *
     * @return $this
     */
    public function setOriginTimezone(?string $origin_timezone): self
    {
        $this->container['origin_timezone'] = $origin_timezone;

        return $this;
    }

    /**
     * Gets origin_country.
     */
    public function getOriginCountry(): ?string
    {
        return $this->container['origin_country'];
    }

    /**
     * Sets origin_country.
     *
     * @param ?string $origin_country Country of the request (only for Android SDK version >= 2.4.0, ISO 3166 format or unknown).
     *
     * @return $this
     */
    public function setOriginCountry(?string $origin_country): self
    {
        $this->container['origin_country'] = $origin_country;

        return $this;
    }

    /**
     * Gets methods.
     */
    public function getMethods(): ?VPNMethods
    {
        return $this->container['methods'];
    }

    /**
     * Sets methods.
     *
     * @param ?\Fingerprint\ServerAPI\Model\VPNMethods $methods methods
     *
     * @return $this
     */
    public function setMethods(?VPNMethods $methods): self
    {
        $this->container['methods'] = $methods;

        return $this;
    }

    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param int $offset Offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param int $offset Offset
     */
    public function offsetGet($offset): mixed
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int   $offset Offset
     * @param mixed $value  Value to be set
     */
    public function offsetSet($offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param int $offset Offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object in a pretty JSON format.
     *
     */
    public function toPrettyString(): string
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }
}