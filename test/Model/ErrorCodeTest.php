<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\ErrorCode;
use Fingerprint\ServerSdk\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(ErrorCode::class)]
class ErrorCodeTest extends TestCase
{
    /**
     * Tests that all expected enum cases exist.
     */
    public function testEnumCases(): void
    {
        $cases = ErrorCode::cases();
        $this->assertCount(17, $cases);
        $this->assertContains(ErrorCode::REQUEST_CANNOT_BE_PARSED, $cases);
        $this->assertContains(ErrorCode::SECRET_API_KEY_REQUIRED, $cases);
        $this->assertContains(ErrorCode::SECRET_API_KEY_NOT_FOUND, $cases);
        $this->assertContains(ErrorCode::PUBLIC_API_KEY_REQUIRED, $cases);
        $this->assertContains(ErrorCode::PUBLIC_API_KEY_NOT_FOUND, $cases);
        $this->assertContains(ErrorCode::SUBSCRIPTION_NOT_ACTIVE, $cases);
        $this->assertContains(ErrorCode::WRONG_REGION, $cases);
        $this->assertContains(ErrorCode::FEATURE_NOT_ENABLED, $cases);
        $this->assertContains(ErrorCode::VISITOR_NOT_FOUND, $cases);
        $this->assertContains(ErrorCode::TOO_MANY_REQUESTS, $cases);
        $this->assertContains(ErrorCode::STATE_NOT_READY, $cases);
        $this->assertContains(ErrorCode::FAILED, $cases);
        $this->assertContains(ErrorCode::EVENT_NOT_FOUND, $cases);
        $this->assertContains(ErrorCode::MISSING_MODULE, $cases);
        $this->assertContains(ErrorCode::PAYLOAD_TOO_LARGE, $cases);
        $this->assertContains(ErrorCode::SERVICE_UNAVAILABLE, $cases);
        $this->assertContains(ErrorCode::RULESET_NOT_FOUND, $cases);
    }

    /**
     * Tests that each enum case has the correct backing value.
     */
    public function testEnumBackingValues(): void
    {
        $this->assertEquals('request_cannot_be_parsed', ErrorCode::REQUEST_CANNOT_BE_PARSED->value);
        $this->assertEquals('secret_api_key_required', ErrorCode::SECRET_API_KEY_REQUIRED->value);
        $this->assertEquals('secret_api_key_not_found', ErrorCode::SECRET_API_KEY_NOT_FOUND->value);
        $this->assertEquals('public_api_key_required', ErrorCode::PUBLIC_API_KEY_REQUIRED->value);
        $this->assertEquals('public_api_key_not_found', ErrorCode::PUBLIC_API_KEY_NOT_FOUND->value);
        $this->assertEquals('subscription_not_active', ErrorCode::SUBSCRIPTION_NOT_ACTIVE->value);
        $this->assertEquals('wrong_region', ErrorCode::WRONG_REGION->value);
        $this->assertEquals('feature_not_enabled', ErrorCode::FEATURE_NOT_ENABLED->value);
        $this->assertEquals('visitor_not_found', ErrorCode::VISITOR_NOT_FOUND->value);
        $this->assertEquals('too_many_requests', ErrorCode::TOO_MANY_REQUESTS->value);
        $this->assertEquals('state_not_ready', ErrorCode::STATE_NOT_READY->value);
        $this->assertEquals('failed', ErrorCode::FAILED->value);
        $this->assertEquals('event_not_found', ErrorCode::EVENT_NOT_FOUND->value);
        $this->assertEquals('missing_module', ErrorCode::MISSING_MODULE->value);
        $this->assertEquals('payload_too_large', ErrorCode::PAYLOAD_TOO_LARGE->value);
        $this->assertEquals('service_unavailable', ErrorCode::SERVICE_UNAVAILABLE->value);
        $this->assertEquals('ruleset_not_found', ErrorCode::RULESET_NOT_FOUND->value);
    }

    /**
     * Tests that valid backing values can be converted to enum instances using from().
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(ErrorCode::REQUEST_CANNOT_BE_PARSED, ErrorCode::from('request_cannot_be_parsed'));
        $this->assertSame(ErrorCode::SECRET_API_KEY_REQUIRED, ErrorCode::from('secret_api_key_required'));
        $this->assertSame(ErrorCode::SECRET_API_KEY_NOT_FOUND, ErrorCode::from('secret_api_key_not_found'));
        $this->assertSame(ErrorCode::PUBLIC_API_KEY_REQUIRED, ErrorCode::from('public_api_key_required'));
        $this->assertSame(ErrorCode::PUBLIC_API_KEY_NOT_FOUND, ErrorCode::from('public_api_key_not_found'));
        $this->assertSame(ErrorCode::SUBSCRIPTION_NOT_ACTIVE, ErrorCode::from('subscription_not_active'));
        $this->assertSame(ErrorCode::WRONG_REGION, ErrorCode::from('wrong_region'));
        $this->assertSame(ErrorCode::FEATURE_NOT_ENABLED, ErrorCode::from('feature_not_enabled'));
        $this->assertSame(ErrorCode::VISITOR_NOT_FOUND, ErrorCode::from('visitor_not_found'));
        $this->assertSame(ErrorCode::TOO_MANY_REQUESTS, ErrorCode::from('too_many_requests'));
        $this->assertSame(ErrorCode::STATE_NOT_READY, ErrorCode::from('state_not_ready'));
        $this->assertSame(ErrorCode::FAILED, ErrorCode::from('failed'));
        $this->assertSame(ErrorCode::EVENT_NOT_FOUND, ErrorCode::from('event_not_found'));
        $this->assertSame(ErrorCode::MISSING_MODULE, ErrorCode::from('missing_module'));
        $this->assertSame(ErrorCode::PAYLOAD_TOO_LARGE, ErrorCode::from('payload_too_large'));
        $this->assertSame(ErrorCode::SERVICE_UNAVAILABLE, ErrorCode::from('service_unavailable'));
        $this->assertSame(ErrorCode::RULESET_NOT_FOUND, ErrorCode::from('ruleset_not_found'));
    }

    /**
     * Tests that tryFrom() returns null for an invalid backing value.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(ErrorCode::tryFrom('invalid'));
    }

    /**
     * Tests that the ObjectSerializer correctly deserializes a string into the enum.
     */
    public function testDeserialization(): void
    {
        $deserialized = ObjectSerializer::deserialize('request_cannot_be_parsed', ErrorCode::class);
        $this->assertSame(ErrorCode::REQUEST_CANNOT_BE_PARSED, $deserialized);
    }
}
