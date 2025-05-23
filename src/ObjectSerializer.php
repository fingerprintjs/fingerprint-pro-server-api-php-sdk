<?php

/**
 * ObjectSerializer.
 *
 * PHP version 5
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

namespace Fingerprint\ServerAPI;

use Psr\Http\Message\ResponseInterface;

/**
 * ObjectSerializer Class Doc Comment.
 *
 * @category Class
 *
 * @author   Swagger Codegen team
 *
 * @see     https://github.com/swagger-api/swagger-codegen
 */
class ObjectSerializer
{
    /**
     * Serialize data.
     *
     * @param mixed       $data   the data to serialize
     * @param string|null $format the format of the Swagger type of the data
     *
     * @return array|object|string serialized form of $data
     */
    public static function sanitizeForSerialization(mixed $data, ?string $format = null): array|bool|object|string
    {
        if (is_scalar($data) || null === $data) {
            return $data;
        }
        if ($data instanceof \DateTime) {
            return ('date' === $format) ? $data->format('Y-m-d') : $data->format(\DateTime::ATOM);
        }
        if (is_array($data)) {
            foreach ($data as $property => $value) {
                if (is_scalar($value)) {
                    $data[$property] = $value;
                } else {
                    $data[$property] = self::sanitizeForSerialization($value);
                }
            }

            return $data;
        }
        if ($data instanceof \stdClass) {
            foreach ($data as $property => $value) {
                if (is_scalar($value)) {
                    $data->{$property} = $value;
                } else {
                    $data->{$property} = self::sanitizeForSerialization($value);
                }
            }

            return $data;
        }

        if (is_object($data)) {
            $class = get_class($data);
            if (enum_exists($class)) {
                return $data->value;
            }
            $values = [];
            $formats = $data::swaggerFormats();
            foreach ($data::swaggerTypes() as $property => $swaggerType) {
                $getter = $data::getters()[$property];
                $value = $data->{$getter}();
                if (null !== $value
                    && !in_array($swaggerType, ['DateTime', 'bool', 'boolean', 'byte', 'double', 'float', 'int', 'integer', 'mixed', 'number', 'object', 'string', 'void'], true)
                    && method_exists($swaggerType, 'getAllowableEnumValues')
                    && !in_array($value, $swaggerType::getAllowableEnumValues())) {
                    $imploded = implode("', '", $swaggerType::getAllowableEnumValues());

                    throw new \InvalidArgumentException("Invalid value for enum '{$swaggerType}', must be one of: '{$imploded}'");
                }
                if (null !== $value) {
                    if (is_scalar($value)) {
                        $values[$data::attributeMap()[$property]] = $value;
                    } elseif ('tag' === $property && empty($value)) {
                        $values[$data::attributeMap()[$property]] = new \stdClass();
                    } else {
                        $values[$data::attributeMap()[$property]] = self::sanitizeForSerialization($value, $swaggerType, $formats[$property]);
                    }
                }
            }

            return (object) $values;
        }

        return (string) $data;
    }

    /**
     * Take value and turn it into a string suitable for inclusion in
     * the path, by url-encoding.
     *
     * @param string $value a string which will be part of the path
     *
     * @return string the serialized object
     */
    public static function toPathValue(string $value): string
    {
        return rawurlencode(self::toString($value));
    }

    /**
     * Take value and turn it into a string suitable for inclusion in
     * the query, by imploding comma-separated if it's an object.
     * If it's a string, pass through unchanged. It will be url-encoded
     * later.
     *
     * @param \DateTime|string|string[] $object an object to be serialized to a string
     * @param string|null               $format the format of the parameter
     *
     * @return string the serialized object
     */
    public static function toQueryValue(array|bool|\DateTime|string $object, ?string $format = null): string
    {
        if (is_array($object)) {
            return implode(',', $object);
        }

        if (is_bool($object)) {
            return $object ? 'true' : 'false';
        }

        return self::toString($object, $format);
    }

    /**
     * Take value and turn it into a string suitable for inclusion in
     * the parameter. If it's a string, pass through unchanged
     * If it's a datetime object, format it in RFC3339
     * If it's a date, format it in Y-m-d.
     *
     * @param \DateTime|string $value  the value of the parameter
     * @param string|null      $format the format of the parameter
     *
     * @return string the header string
     */
    public static function toString(\DateTime|string $value, ?string $format = null): string
    {
        if ($value instanceof \DateTime) {
            return ('date' === $format) ? $value->format('Y-m-d') : $value->format(\DateTime::ATOM);
        }

        return $value;
    }

    /**
     * Deserialize a JSON string into an object.
     *
     * @param string $class class name is passed as a string
     *
     * @throws \Exception
     */
    public static function deserialize(ResponseInterface $response, string $class): mixed
    {
        $data = $response->getBody()->getContents();
        $response->getBody()->rewind();

        return self::mapToClass($data, $class, $response);
    }

    protected static function mapToClass(mixed $data, string $class, ResponseInterface $response): mixed
    {
        if ('string' === gettype($data)) {
            $data = json_decode($data, false);
        }
        $instance = new $class();
        foreach ($instance::swaggerTypes() as $property => $type) {
            $propertySetter = $instance::setters()[$property];

            if (!isset($propertySetter) || !isset($data->{$instance::attributeMap()[$property]})) {
                continue;
            }

            $propertyValue = $data->{$instance::attributeMap()[$property]};
            if (isset($propertyValue)) {
                $instance->{$propertySetter}(self::castData($propertyValue, $type, $response));
            }
        }

        return $instance;
    }

    protected static function castData(mixed $data, string $class, ResponseInterface $response): mixed
    {
        if (null === $data) {
            return null;
        }
        if (str_starts_with($class, 'map[')) { // for associative array e.g. map[string,int]
            $inner = substr($class, 4, -1);
            $deserialized = [];
            if (false !== strrpos($inner, ',')) {
                $subClass_array = explode(',', $inner, 2);
                $subClass = $subClass_array[1];
                foreach ($data as $key => $value) {
                    $deserialized[$key] = self::castData($value, $subClass, $response);
                }
            }

            return $deserialized;
        }
        if (0 === strcasecmp(substr($class, -2), '[]')) {
            $subClass = substr($class, 0, -2);
            $values = [];
            foreach ($data as $key => $value) {
                $values[] = self::castData($value, $subClass, $response);
            }

            return $values;
        }
        if ('mixed' === $class) {
            if ($data instanceof \stdClass) {
                if (empty(get_object_vars($data))) {
                    return null;
                }

                return (array) $data;
            }

            return $data;
        }
        if ('object' === $class || 'array' === $class) {
            settype($data, 'array');

            return $data;
        }
        if ('\DateTime' === $class) {
            // Some API's return an invalid, empty string as a
            // date-time property. DateTime::__construct() will return
            // the current time for empty input which is probably not
            // what is meant. The invalid empty string is probably to
            // be interpreted as a missing field/value. Let's handle
            // this graceful.
            if (!empty($data)) {
                return new \DateTime($data);
            }

            return null;
        }
        if (in_array($class, ['DateTime', 'bool', 'boolean', 'byte', 'double', 'float', 'int', 'integer', 'mixed', 'number', 'object', 'string', 'void'], true)) {
            $originalData = $data;
            $normalizedClass = strtolower($class);

            switch ($normalizedClass) {
                case 'int':
                    $normalizedClass = 'integer';

                    break;

                case 'bool':
                    $normalizedClass = 'boolean';

                    break;
            }
            if ('float' === $normalizedClass && is_numeric($originalData)) {
                return (float) $originalData;
            }
            if ('string' === $normalizedClass && is_object($data)) {
                throw new SerializationException($response);
            }

            settype($data, $class);
            if (gettype($data) === $normalizedClass) {
                return $data;
            }

            throw new SerializationException($response);
        } elseif (enum_exists($class)) {
            try {
                return $class::from($data);
            } catch (\ValueError $e) {
                $allowedValues = array_map(fn ($case) => $case->value, $class::cases());
                $imploded = implode("', '", $allowedValues);

                throw new \InvalidArgumentException("Invalid value '{$data}' for enum '{$class}', must be one of: '{$imploded}'");
            }

            return $data;
        }

        return self::mapToClass($data, $class, $response);
    }
}
