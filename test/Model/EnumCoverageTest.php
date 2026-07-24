<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\BotInfoCategory;
use Fingerprint\ServerSdk\Model\BotInfoConfidence;
use Fingerprint\ServerSdk\Model\BotInfoIdentity;
use Fingerprint\ServerSdk\Model\BotResult;
use Fingerprint\ServerSdk\Model\ErrorCode;
use Fingerprint\ServerSdk\Model\IncrementalIdentificationStatus;
use Fingerprint\ServerSdk\Model\ProxyConfidence;
use Fingerprint\ServerSdk\Model\RareDevicePercentileBucket;
use Fingerprint\ServerSdk\Model\RuleActionType;
use Fingerprint\ServerSdk\Model\SearchEventsBot;
use Fingerprint\ServerSdk\Model\SearchEventsBotInfo;
use Fingerprint\ServerSdk\Model\SearchEventsIncrementalIdentificationStatus;
use Fingerprint\ServerSdk\Model\SearchEventsRareDevicePercentileBucket;
use Fingerprint\ServerSdk\Model\SearchEventsSdkPlatform;
use Fingerprint\ServerSdk\Model\SearchEventsSource;
use Fingerprint\ServerSdk\Model\SearchEventsVpnConfidence;
use Fingerprint\ServerSdk\Model\TamperingConfidence;
use Fingerprint\ServerSdk\Model\VpnConfidence;
use Fingerprint\ServerSdk\ObjectSerializer;
use Fingerprint\ServerSdk\Sealed\DecryptionAlgorithm;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests that all enum types can be instantiated from their defined values
 * and that tryFrom returns null for unknown values.
 *
 * @internal
 */
#[CoversClass(BotInfoCategory::class)]
#[CoversClass(BotInfoConfidence::class)]
#[CoversClass(BotInfoIdentity::class)]
#[CoversClass(BotResult::class)]
#[CoversClass(ErrorCode::class)]
#[CoversClass(IncrementalIdentificationStatus::class)]
#[CoversClass(ProxyConfidence::class)]
#[CoversClass(RareDevicePercentileBucket::class)]
#[CoversClass(RuleActionType::class)]
#[CoversClass(SearchEventsBot::class)]
#[CoversClass(SearchEventsBotInfo::class)]
#[CoversClass(SearchEventsIncrementalIdentificationStatus::class)]
#[CoversClass(SearchEventsRareDevicePercentileBucket::class)]
#[CoversClass(SearchEventsSdkPlatform::class)]
#[CoversClass(SearchEventsSource::class)]
#[CoversClass(SearchEventsVpnConfidence::class)]
#[CoversClass(TamperingConfidence::class)]
#[CoversClass(VpnConfidence::class)]
#[CoversClass(DecryptionAlgorithm::class)]
class EnumCoverageTest extends TestCase
{
    /**
     * @param class-string<\BackedEnum> $enumClass
     */
    #[DataProvider('enumClassProvider')]
    public function testAllCasesAreResolvableViaFrom(string $enumClass): void
    {
        $cases = $enumClass::cases();
        $this->assertNotEmpty($cases, "$enumClass should define at least one case");

        foreach ($cases as $case) {
            $resolved = $enumClass::from($case->value);
            $this->assertSame($case, $resolved);
        }
    }

    /**
     * @param class-string<\BackedEnum> $enumClass
     */
    #[DataProvider('enumClassProvider')]
    public function testTryFromReturnsNullForUnknownValue(string $enumClass): void
    {
        $result = $enumClass::tryFrom('__nonexistent_value__');
        $this->assertNull($result);
    }

    /**
     * @param class-string<\BackedEnum> $enumClass
     * @throws \DateMalformedStringException
     */
    #[DataProvider('enumClassProvider')]
    public function testObjectSerializerDeserializesAllCases(string $enumClass): void
    {
        foreach ($enumClass::cases() as $case) {
            $deserialized = ObjectSerializer::deserialize($case->value, $enumClass);
            $this->assertSame($case, $deserialized);
        }
    }

    /**
     * @return array<string, array{class-string<\BackedEnum>}>
     */
    public static function enumClassProvider(): array
    {
        return [
            'BotInfoCategory' => [BotInfoCategory::class],
            'BotInfoConfidence' => [BotInfoConfidence::class],
            'BotInfoIdentity' => [BotInfoIdentity::class],
            'BotResult' => [BotResult::class],
            'ErrorCode' => [ErrorCode::class],
            'IncrementalIdentificationStatus' => [IncrementalIdentificationStatus::class],
            'ProxyConfidence' => [ProxyConfidence::class],
            'RareDevicePercentileBucket' => [RareDevicePercentileBucket::class],
            'RuleActionType' => [RuleActionType::class],
            'SearchEventsBot' => [SearchEventsBot::class],
            'SearchEventsBotInfo' => [SearchEventsBotInfo::class],
            'SearchEventsIncrementalIdentificationStatus' => [SearchEventsIncrementalIdentificationStatus::class],
            'SearchEventsRareDevicePercentileBucket' => [SearchEventsRareDevicePercentileBucket::class],
            'SearchEventsSdkPlatform' => [SearchEventsSdkPlatform::class],
            'SearchEventsSource' => [SearchEventsSource::class],
            'SearchEventsVpnConfidence' => [SearchEventsVpnConfidence::class],
            'TamperingConfidence' => [TamperingConfidence::class],
            'VpnConfidence' => [VpnConfidence::class],
            'DecryptionAlgorithm' => [DecryptionAlgorithm::class],
        ];
    }
}
