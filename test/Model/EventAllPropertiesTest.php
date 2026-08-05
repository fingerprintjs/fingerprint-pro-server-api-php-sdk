<?php

namespace Fingerprint\ServerSdk\Test\Model;

use Fingerprint\ServerSdk\Model\BotInfo;
use Fingerprint\ServerSdk\Model\BotResult;
use Fingerprint\ServerSdk\Model\BrowserDetails;
use Fingerprint\ServerSdk\Model\Event;
use Fingerprint\ServerSdk\Model\EventRuleAction;
use Fingerprint\ServerSdk\Model\Geolocation;
use Fingerprint\ServerSdk\Model\Identification;
use Fingerprint\ServerSdk\Model\IPBlockList;
use Fingerprint\ServerSdk\Model\IPInfo;
use Fingerprint\ServerSdk\Model\LabelsInner;
use Fingerprint\ServerSdk\Model\Proximity;
use Fingerprint\ServerSdk\Model\ProxyDetails;
use Fingerprint\ServerSdk\Model\RawDeviceAttributes;
use Fingerprint\ServerSdk\Model\SDK;
use Fingerprint\ServerSdk\Model\SupplementaryIDHighRecall;
use Fingerprint\ServerSdk\Model\TamperingDetails;
use Fingerprint\ServerSdk\Model\Velocity;
use Fingerprint\ServerSdk\Model\VpnMethods;
use Fingerprint\ServerSdk\ObjectSerializer;
use Fingerprint\ServerSdk\Test\SealedTest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Event properties not covered by EventTest.
 *
 * @internal
 */
#[CoversClass(Event::class)]
#[CoversClass(RawDeviceAttributes::class)]
#[CoversClass(Velocity::class)]
#[CoversClass(Geolocation::class)]
#[CoversClass(SDK::class)]
#[CoversClass(BrowserDetails::class)]
#[CoversClass(Identification::class)]
#[CoversClass(SupplementaryIDHighRecall::class)]
#[CoversClass(IPInfo::class)]
#[CoversClass(IPBlockList::class)]
#[CoversClass(ProxyDetails::class)]
#[CoversClass(VpnMethods::class)]
#[CoversClass(TamperingDetails::class)]
class EventAllPropertiesTest extends TestCase
{
    private Event $event;

    protected function setUp(): void
    {
        $this->event = ObjectSerializer::deserialize(
            json_decode(SealedTest::EXAMPLE_JSON),
            Event::class
        );
    }

    public function testBasicProperties(): void
    {
        $this->assertSame('1708102555327.NLOjmg', $this->event->getEventId());
        $this->assertSame(1708102555327, $this->event->getTimestamp());
        $this->assertSame('somelinkedId', $this->event->getLinkedId());
        $this->assertSame('https://www.example.com/login?hope{this{works[!', $this->event->getUrl());
        $this->assertSame('61.127.217.15', $this->event->getIpAddress());
        $this->assertStringContainsString('Mozilla', $this->event->getUserAgent());
    }

    public function testBooleanProperties(): void
    {
        $this->assertFalse($this->event->getIncognito());
        $this->assertFalse($this->event->getTampering());
        $this->assertFalse($this->event->getClonedApp());
        $this->assertFalse($this->event->getJailbroken());
        $this->assertFalse($this->event->getFrida());
        $this->assertFalse($this->event->getPrivacySettings());
        $this->assertFalse($this->event->getVirtualMachine());
        $this->assertFalse($this->event->getLocationSpoofing());
        $this->assertFalse($this->event->getDeveloperTools());
        $this->assertFalse($this->event->getMitmAttack());
        $this->assertFalse($this->event->getReplayed());
        $this->assertFalse($this->event->getRootApps());
        $this->assertFalse($this->event->getEmulator());
        $this->assertTrue($this->event->getProxy());
        $this->assertFalse($this->event->getVpn());
    }

    public function testEnumProperties(): void
    {
        $this->assertSame(BotResult::NOT_DETECTED, $this->event->getBot());
        $this->assertSame('Europe/Berlin', $this->event->getVpnOriginTimezone());
        $this->assertSame('unknown', $this->event->getVpnOriginCountry());
    }

    public function testFactoryResetTimestamp(): void
    {
        $this->assertSame(0, $this->event->getFactoryResetTimestamp());
    }

    public function testBrowserDetails(): void
    {
        $details = $this->event->getBrowserDetails();
        $this->assertInstanceOf(BrowserDetails::class, $details);
        $this->assertSame('Chrome', $details->getBrowserName());
        $this->assertSame('74', $details->getBrowserMajorVersion());
        $this->assertSame('74.0.3729', $details->getBrowserFullVersion());
        $this->assertSame('Windows', $details->getOs());
        $this->assertSame('7', $details->getOsVersion());
        $this->assertSame('Other', $details->getDevice());
    }

    public function testIdentification(): void
    {
        $id = $this->event->getIdentification();
        $this->assertInstanceOf(Identification::class, $id);
        $this->assertSame('Ibk1527CUFmcnjLwIs4A9', $id->getVisitorId());
        $this->assertFalse($id->getVisitorFound());
        $confidence = $id->getConfidence();
        $this->assertSame(0.97, $confidence->getScore());
    }

    public function testSupplementaryIdHighRecall(): void
    {
        $supp = $this->event->getSupplementaryIdHighRecall();
        $this->assertInstanceOf(SupplementaryIDHighRecall::class, $supp);
        $this->assertSame('3HNey93AkBW6CRbxV6xP', $supp->getVisitorId());
        $this->assertTrue($supp->getVisitorFound());
    }

    public function testIpInfo(): void
    {
        $ipInfo = $this->event->getIpInfo();
        $this->assertInstanceOf(IPInfo::class, $ipInfo);

        $v4 = $ipInfo->getV4();
        $this->assertSame('94.142.239.124', $v4->getAddress());
        $this->assertSame('7922', $v4->getAsn());
        $this->assertSame('COMCAST-7922', $v4->getAsnName());
        $this->assertTrue($v4->getDatacenterResult());

        $v6 = $ipInfo->getV6();
        $this->assertSame('2001:db8:3333:4444:5555:6666:7777:8888', $v6->getAddress());
        $this->assertFalse($v6->getDatacenterResult());
    }

    public function testGeolocation(): void
    {
        $geo = $this->event->getIpInfo()->getV4()->getGeolocation();
        $this->assertInstanceOf(Geolocation::class, $geo);
        $this->assertSame(20, $geo->getAccuracyRadius());
        $this->assertSame(50.05, $geo->getLatitude());
        $this->assertSame(14.4, $geo->getLongitude());
        $this->assertSame('150 00', $geo->getPostalCode());
        $this->assertSame('Europe/Prague', $geo->getTimezone());
        $this->assertSame('Prague', $geo->getCityName());
        $this->assertSame('CZ', $geo->getCountryCode());
        $this->assertSame('Czechia', $geo->getCountryName());
        $this->assertSame('EU', $geo->getContinentCode());
        $this->assertSame('Europe', $geo->getContinentName());
        $this->assertNotEmpty($geo->getSubdivisions());
    }

    public function testIpBlocklist(): void
    {
        $blocklist = $this->event->getIpBlocklist();
        $this->assertInstanceOf(IPBlockList::class, $blocklist);
        $this->assertFalse($blocklist->getEmailSpam());
        $this->assertFalse($blocklist->getAttackSource());
        $this->assertFalse($blocklist->getTorNode());
    }

    public function testProxyDetails(): void
    {
        $proxy = $this->event->getProxyDetails();
        $this->assertInstanceOf(ProxyDetails::class, $proxy);
        $this->assertSame('residential', $proxy->getProxyType());
    }

    public function testVpnMethods(): void
    {
        $methods = $this->event->getVpnMethods();
        $this->assertInstanceOf(VpnMethods::class, $methods);
        $this->assertFalse($methods->getTimezoneMismatch());
        $this->assertFalse($methods->getPublicVpn());
        $this->assertFalse($methods->getAuxiliaryMobile());
        $this->assertFalse($methods->getOsMismatch());
        $this->assertFalse($methods->getRelay());
    }

    public function testTamperingDetails(): void
    {
        $details = $this->event->getTamperingDetails();
        $this->assertInstanceOf(TamperingDetails::class, $details);
        $this->assertSame(0.1955, $details->getAnomalyScore());
        $this->assertFalse($details->getAntiDetectBrowser());
    }

    public function testSdkInfo(): void
    {
        $sdk = $this->event->getSdk();
        $this->assertInstanceOf(SDK::class, $sdk);
        $this->assertSame('js', $sdk->getPlatform());
        $this->assertSame('3.11.10', $sdk->getVersion());
    }

    public function testVelocity(): void
    {
        $velocity = $this->event->getVelocity();
        $this->assertInstanceOf(Velocity::class, $velocity);
        $this->assertNotNull($velocity->getDistinctIp());
        $this->assertNotNull($velocity->getDistinctCountry());
        $this->assertNotNull($velocity->getEvents());
        $this->assertNotNull($velocity->getIpEvents());
        $this->assertNotNull($velocity->getDistinctIpByLinkedId());
        $this->assertNotNull($velocity->getDistinctVisitorIdByLinkedId());
    }

    // -- Setter tests for properties not covered by deserialization --

    public function testSetBooleanProperties(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $event->setIncognito(true);
        $event->setTampering(true);
        $event->setClonedApp(true);
        $event->setJailbroken(true);
        $event->setFrida(true);
        $event->setPrivacySettings(true);
        $event->setVirtualMachine(true);
        $event->setLocationSpoofing(true);
        $event->setDeveloperTools(true);
        $event->setMitmAttack(true);
        $event->setReplayed(true);
        $event->setRootApps(true);
        $event->setEmulator(true);
        $event->setProxy(true);
        $event->setVpn(true);
        $event->setHighActivityDevice(true);
        $event->setRareDevice(true);
        $event->setSuspect(true);

        $this->assertTrue($event->getIncognito());
        $this->assertTrue($event->getSuspect());
        $this->assertTrue($event->getHighActivityDevice());
        $this->assertTrue($event->getRareDevice());
    }

    public function testSetComplexProperties(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $event->setTags(['key' => 'value']);
        $event->setEnvironmentId('env-1');
        $event->setBundleId('com.test');
        $event->setPackageName('com.test.pkg');
        $event->setDevice('iPhone');
        $event->setOs('iOS');
        $event->setOsVersion('17.0');
        $event->setClientReferrer('https://ref.com');

        $this->assertSame(['key' => 'value'], $event->getTags());
        $this->assertSame('env-1', $event->getEnvironmentId());
        $this->assertSame('com.test', $event->getBundleId());
        $this->assertSame('com.test.pkg', $event->getPackageName());
        $this->assertSame('iPhone', $event->getDevice());
        $this->assertSame('iOS', $event->getOs());
        $this->assertSame('17.0', $event->getOsVersion());
        $this->assertSame('https://ref.com', $event->getClientReferrer());
    }

    public function testSetSubObjectProperties(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);

        $event->setBotInfo(new BotInfo());
        $this->assertInstanceOf(BotInfo::class, $event->getBotInfo());

        $event->setBotType('bad');
        $this->assertSame('bad', $event->getBotType());

        $event->setRuleAction(new EventRuleAction());
        $this->assertInstanceOf(EventRuleAction::class, $event->getRuleAction());

        $event->setLabels([new LabelsInner(['label' => 'test'])]);
        $this->assertCount(1, $event->getLabels());

        $event->setRawDeviceAttributes(new RawDeviceAttributes());
        $this->assertInstanceOf(RawDeviceAttributes::class, $event->getRawDeviceAttributes());

        $event->setRareDevicePercentileBucket('p95-p99');
        $this->assertSame('p95-p99', $event->getRareDevicePercentileBucket());

        $event->setIncrementalIdentificationStatus('completed');
        $this->assertSame('completed', $event->getIncrementalIdentificationStatus());

        $event->setSimulator(false);
        $this->assertFalse($event->getSimulator());

        $this->assertNull($event->getSuspectScore());
        $event->setSuspectScore(75);
        $this->assertSame(75, $event->getSuspectScore());
    }

    public function testMlScoreSettersValid(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $event->setProxyMlScore(0.5);
        $event->setTamperingMlScore(0.5);
        $event->setVirtualMachineMlScore(0.5);
        $event->setVpnMlScore(0.5);

        $this->assertSame(0.5, $event->getProxyMlScore());
        $this->assertSame(0.5, $event->getTamperingMlScore());
        $this->assertSame(0.5, $event->getVirtualMachineMlScore());
        $this->assertSame(0.5, $event->getVpnMlScore());
    }

    public function testProxyMlScoreUpperBound(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $this->expectException(\InvalidArgumentException::class);
        $event->setProxyMlScore(1.1);
    }

    public function testProxyMlScoreLowerBound(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $this->expectException(\InvalidArgumentException::class);
        $event->setProxyMlScore(-0.1);
    }

    public function testTamperingMlScoreUpperBound(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $this->expectException(\InvalidArgumentException::class);
        $event->setTamperingMlScore(1.1);
    }

    public function testTamperingMlScoreLowerBound(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $this->expectException(\InvalidArgumentException::class);
        $event->setTamperingMlScore(-0.1);
    }

    public function testVirtualMachineMlScoreUpperBound(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $this->expectException(\InvalidArgumentException::class);
        $event->setVirtualMachineMlScore(1.1);
    }

    public function testVirtualMachineMlScoreLowerBound(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $this->expectException(\InvalidArgumentException::class);
        $event->setVirtualMachineMlScore(-0.1);
    }

    public function testVpnMlScoreUpperBound(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $this->expectException(\InvalidArgumentException::class);
        $event->setVpnMlScore(1.1);
    }

    public function testVpnMlScoreLowerBound(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $this->expectException(\InvalidArgumentException::class);
        $event->setVpnMlScore(-0.1);
    }

    public function testMlScoreValidationInListInvalidProperties(): void
    {
        $event = new Event([
            'event_id' => 'e',
            'timestamp' => 1,
            'proxy_ml_score' => 1.5,
            'tampering_ml_score' => -1,
            'virtual_machine_ml_score' => 2.0,
            'vpn_ml_score' => -0.5,
        ]);
        $invalid = $event->listInvalidProperties();
        $this->assertNotEmpty($invalid);
        $this->assertGreaterThanOrEqual(4, count($invalid));
    }

    public function testMlScoreValidationOppositeDirection(): void
    {
        $event = new Event([
            'event_id' => 'e',
            'timestamp' => 1,
            'proxy_ml_score' => -0.1,
            'tampering_ml_score' => 1.5,
            'virtual_machine_ml_score' => -0.1,
            'vpn_ml_score' => 1.5,
        ]);
        $invalid = $event->listInvalidProperties();
        $this->assertNotEmpty($invalid);
        $this->assertGreaterThanOrEqual(4, count($invalid));
    }

    public function testSetProximity(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $proximity = new Proximity();
        $event->setProximity($proximity);
        $this->assertSame($proximity, $event->getProximity());
    }

    public function testSetActiveCall(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $event->setActiveCall(true);
        $this->assertTrue($event->getActiveCall());
    }

    public function testSetTamperingConfidence(): void
    {
        $event = new Event(['event_id' => 'e', 'timestamp' => 1]);
        $event->setTamperingConfidence('high');
        $this->assertSame('high', $event->getTamperingConfidence());
    }
}
