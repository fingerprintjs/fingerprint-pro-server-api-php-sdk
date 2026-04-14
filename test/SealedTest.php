<?php

namespace Fingerprint\ServerSdk\Test;

use Fingerprint\ServerSdk\Model\BotResult;
use Fingerprint\ServerSdk\Model\BrowserDetails;
use Fingerprint\ServerSdk\Model\Event;
use Fingerprint\ServerSdk\Model\Geolocation;
use Fingerprint\ServerSdk\Model\IdentificationConfidence;
use Fingerprint\ServerSdk\ObjectSerializer;
use Fingerprint\ServerSdk\Sealed\DecompressionException;
use Fingerprint\ServerSdk\Sealed\DecryptionAlgorithm;
use Fingerprint\ServerSdk\Sealed\DecryptionKey;
use Fingerprint\ServerSdk\Sealed\InvalidSealedDataException;
use Fingerprint\ServerSdk\Sealed\InvalidSealedDataHeaderException;
use Fingerprint\ServerSdk\Sealed\Sealed;
use Fingerprint\ServerSdk\Sealed\UnsealAggregateException;
use Fingerprint\ServerSdk\Sealed\UnsealException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Sealed::class)]
class SealedTest extends TestCase
{
    public const VALID_KEY = 'p2PA7MGy5tx56cnyJaFZMr96BCFwZeHjZV2EqMvTq53=';
    public const INVALID_KEY = 'p2PA7MGy5tx56cnyJaFZMr96BCFwZeHjZV2EqMvTq54=';
    public const SEALED_RESULT = 'noXc7Xu7PIKu1tbMkMxLbQG4XU46Bv5dED98hqTkPYZnmb8PG81Q83Kpg541Vt4NQdkzfezDSVk8FP9ZzJ08L0MMb4S8bT78c10Op1LyKwZU6DGr1e3V+ZWcNzHVG1rPoL+eUHN6yR9MQp8/CmSUBQUPOOAUXdoqWohbfIGxoQIuQ5BtfpSJuYD6kTyswSi56wxzY/s24dMwgS2KnA81Y1pdi3ZVJKBdwGYGg4T5Dvcqu0GWv3sScKD9b4Tagfbe2m8nbXY/QtN770c7J1xo/TNXXdq4lyqaMyqIayHOwRBP58tNF8mACusm1pogOVIt456wIMetCGKxicPJr7m/Q02ONzhkMtzzXwgwriglGHfM7UbtTsCytCBP7J2vp0tEkHiq/X3qtuvSLJqNyRzwFJhgisKGftc5CIaT2VxVKKxkL/6Ws6FPm4sQB1UGtMCMftKpyb1lFzG9lwFkKvYN9+FGtvRM50mbrzz7ONDxbwykkxihAab36MIuk7dfhvnVLFAjrpuCkEFdWrtjVyWmM0xVeXpEUtP6Ijk5P+VuPZ1alV/JV1q4WvfrGMizEZbwbp6eQZg9mwKe4IX+FVi7sPF2S/CCLI/d90S5Yz6bBP9uiQ3pCVlYbVOkpwS0YQxnR+h5J50qodY7LuswNO5VlEgI0ztkjPQBr8koT4SM54X2z14tA2tKCxSv1psEL5HOk4IWN+9f3RVfDKBDruDiDd+BtZquhYLmOFat9K4h41NrPGAqv5tKmmJtx3llMs6LFHPKBlNlI5zgqE7T47xv2AWw5nqWM107t8lpRETIgJx+YN/Jv6byJSQm7afaeDtHXGceMPOKMziH1XgsiQiS56OsmyyRgaq5YCmMuaPw8gcgVa7RNZSafkP34aQBAuJOA3JFs5xcYcubKutD3h1mk697A8vwdtR/Gj0zTvuUnQ/9o3qHSLseAEIiY9/dS6WJnKXRKTonQi2F6DV9NTzFVQl99AH22jq6lIsjbEEKcq/ydFDUpgAq4lyp9nPBHuPXSojdG+1BWuUyjYykaqnLzzqKgRalGzeWmRHd2qeNw8Bz5OWYBw82C3gHRS2BB9VquIgEYktDvgJ5yRfDYkp8qgxHoYeR88ijccWgdvk+WH78OPdwqA7rqdAYcWqn9KNozoxuYddc0fnrHbgaWpanCmPp0gNEeb4r+i9FDGPSkgYBdyrEPHblsDN/Ad1dhLIHEDEtQyv13s6tDRgLVvhowrzqIM+5cm/abyTDhXzSYDfCw2Wf90cBOMsbQBB2N2YRqnrpA50PGp+0IwlPL7qZj1N4JGhvQD0ux8Ood6AiXpdguj7DMP+T0laHIjWee5/xGZB6g3EsCdOZJjVj7hSE/L3eV4No0WcLqJ5DPOgw+FnvQpxndCTc8DW83tNm624lm7scu0A499vEFj1dhtq5gUxsGcqzm09+Vk2V/d0sa77Xocqe3bcfS5lXc/pHrOc1qKlK8kTr2AYNwjeJJ14euuin361WBETd1I6n8eIs02HyBas09o9lT7Nq05jsnbxej6d0q6GH7IYusiBFTJaAZ6UXOV5i1NOcw9jaGyHms3M2N/b2cmXFYTIFZSjSfbqoI6YZF73sMPhEZqfZ5Jjq+ZLMC3A+yFPFJOW/0oolUGbcC8TBVmLi37Z9Wgc338w2Jf+I94SdViku';
    public const EXAMPLE_JSON = '{"linked_id":"somelinkedId","tags":{},"timestamp":1708102555327,"event_id":"1708102555327.NLOjmg","url":"https://www.example.com/login?hope{this{works[!","ip_address":"61.127.217.15","user_agent":"Mozilla/5.0 (Windows NT 6.1; Win64; x64) ....","browser_details":{"browser_name":"Chrome","browser_major_version":"74","browser_full_version":"74.0.3729","os":"Windows","os_version":"7","device":"Other"},"identification":{"visitor_id":"Ibk1527CUFmcnjLwIs4A9","confidence":{"score":0.97,"version":"1.1"},"visitor_found":false,"first_seen_at":1708102555327,"last_seen_at":1708102555327},"supplementary_id_high_recall":{"visitor_id":"3HNey93AkBW6CRbxV6xP","visitor_found":true,"confidence":{"score":0.97,"version":"1.1"},"first_seen_at":1708102555327,"last_seen_at":1708102555327},"bot":"not_detected","root_apps":false,"emulator":false,"ip_info":{"v4":{"address":"94.142.239.124","geolocation":{"accuracy_radius":20,"latitude":50.05,"longitude":14.4,"postal_code":"150 00","timezone":"Europe/Prague","city_name":"Prague","country_code":"CZ","country_name":"Czechia","continent_code":"EU","continent_name":"Europe","subdivisions":[{"iso_code":"10","name":"Hlavni mesto Praha"}]},"asn":"7922","asn_name":"COMCAST-7922","asn_network":"73.136.0.0/13","datacenter_result":true,"datacenter_name":"DediPath"},"v6":{"address":"2001:db8:3333:4444:5555:6666:7777:8888","geolocation":{"accuracy_radius":5,"latitude":49.982,"longitude":36.2566,"postal_code":"10112","timezone":"Europe/Berlin","city_name":"Berlin","country_code":"DE","country_name":"Germany","continent_code":"EU","continent_name":"Europe","subdivisions":[{"iso_code":"BE","name":"Land Berlin"}]},"asn":"6805","asn_name":"Telefonica Germany","asn_network":"2a02:3100::/24","datacenter_result":false,"datacenter_name":""}},"ip_blocklist":{"email_spam":false,"attack_source":false,"tor_node":false},"proxy":true,"proxy_confidence":"low","proxy_details":{"proxy_type":"residential","last_seen_at":1708102555327},"vpn":false,"vpn_confidence":"high","vpn_origin_timezone":"Europe/Berlin","vpn_origin_country":"unknown","vpn_methods":{"timezone_mismatch":false,"public_vpn":false,"auxiliary_mobile":false,"os_mismatch":false,"relay":false},"incognito":false,"tampering":false,"tampering_details":{"anomaly_score":0.1955,"anti_detect_browser":false},"cloned_app":false,"factory_reset_timestamp":0,"jailbroken":false,"frida":false,"privacy_settings":false,"virtual_machine":false,"location_spoofing":false,"velocity":{"distinct_ip":{"5_minutes":1,"1_hour":1,"24_hours":1},"distinct_country":{"5_minutes":1,"1_hour":2,"24_hours":2},"events":{"5_minutes":1,"1_hour":5,"24_hours":5},"ip_events":{"5_minutes":1,"1_hour":5,"24_hours":5},"distinct_ip_by_linked_id":{"5_minutes":1,"1_hour":5,"24_hours":5},"distinct_visitor_id_by_linked_id":{"5_minutes":1,"1_hour":5,"24_hours":5}},"developer_tools":false,"mitm_attack":false,"sdk":{"platform":"js","version":"3.11.10"},"replayed":false}';

    protected string $validKey;

    protected string $invalidKey;

    /**
     * @var DecryptionKey[]
     */
    protected array $keys;

    protected function setUp(): void
    {
        $this->validKey = base64_decode(self::VALID_KEY);
        $this->invalidKey = base64_decode(self::INVALID_KEY);

        $this->keys = [
            new DecryptionKey($this->invalidKey, DecryptionAlgorithm::AES_256_GCM),
            new DecryptionKey($this->validKey, DecryptionAlgorithm::AES_256_GCM),
        ];
    }

    /**
     * @throws UnsealAggregateException
     */
    public function testUnsealEventResponse()
    {
        $sealedResult = base64_decode(self::SEALED_RESULT);

        $expectedResponse = ObjectSerializer::deserialize(self::EXAMPLE_JSON, Event::class);

        $eventResponse = Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );

        $this->assertEquals($expectedResponse, $eventResponse);
    }

    /**
     * @throws UnsealAggregateException
     */
    public function testUnsealEventResponseWithInvalidSealedResult()
    {
        // "{\"invalid\":true}"
        $sealedResult = base64_decode('noXc7VOpBstjjcavDKSKr4HTavt4mdq8h6NC32T0hUtw9S0jXT8lPjZiWL8SyHxmrF3uTGqO+g==');

        $this->expectException(InvalidSealedDataException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    /**
     * @throws UnsealAggregateException
     */
    public function testUnsealEventResponseWithInvalidJsonSealedResult()
    {
        $sealedResult = base64_decode('noXc7XdbEp5JpFNJaMxCB5leuFeW9Fs0tqvwnbU3ND2yShYn+dgeUWvdk32YrXam4yuvhmpO8gww//Qmsu2sbyvyMRuXmlKoriV9EVPYVCB2xszskg34ngrAh4sreRZV3c8d0DcXZulbMiiXrli931fEABWRHM0NtcoPuubqb+TysNSoFIYVZxpRVDR8jDiTXuQyPzvqBJD4+xeQTOOAOjPlqRTQSSBrlWjeZLNA70wWX7VRDXA1SoR+1k7bkBFK4OwRnh5rVGeGvGeHisOe/SyOL6GlQyBk3sRdSCQiI/g0ywdqLsOk4xDdCgg5vMI07APvL9FSaQrglMvD8NRmQOr5glZoV6S3DoBgaYQVvEygTZy2gfJ0z6hLY6Q8WSW0hpb3t9m4MP9WC5Vc2r0fmfqX7gjYZpwyfJxsyyk4iksminhm2T8N8DTYuZuz82jjaGNDqAPn1PZKqiEh8H9TpcgewAP8mlVrB5CUPJMHH+p7dM5zibfKM9+1MPxvZNp0PBkljBwrfGjiKlmYhn7bb5UW5TeEMtiP27KoA26PX+NV130Vi9Y/LUgMivLwaIc+jnlFyaoqg6Kg6H8G3WhT0r/pc4KP0mwyHJzfXjep8kQZGKxbMd0Sc3h4kpoWR1hdYM4QZRvKQzh7BqBPtPiVgHYoEJf9qFVxYhel9UFONz65q5bA2Y25oFKpzfsiXQqFEo/LRANnW7iUdfesGtGjjP4N6rd8ssNpYf57FmPBpWC4RwjG45MHRUSajCVLKiwUgFQbOo7/t5hgQIQOui3jmCBDjCjpjGZK8vd2nFputUTqI/MmZK7THaDPFsn8h9M1boF3VMCzDXygJFhd5lwdVErXGtQcc1lApEvdOr24QB5Io4SjfjJCfEQ7g4ulBXuqsh6I4VkcuMh5zgBIdmGm');

        $this->expectException(InvalidSealedDataException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    public function testUnsealEventResponseWithNotCompressedSealedResult()
    {
        $sealedResult = base64_decode('noXc7dtuk0smGE+ZbaoXzrp6Rq8ySxLepejTsu7+jUXlPhV1w+WuHx9gbPhaENJnOQo8BcGmsaRhL5k2NVj+DRNzYO9cQD7wHxmXKCyTbl/dvSYOMoHziUZ2VbQ7tmaorFny26v8jROr/UBGfvPE0dLKC36IN9ZlJ3X0NZJO8SY+8bCr4mTrkVZsv/hpvZp+OjC4h7e5vxcpmnBWXzxfaO79Lq3aMRIEf9XfK7/bVIptHaEqtPKCTwl9rz1KUpUUNQSHTPM0NlqJe9bjYf5mr1uYvWHhcJoXSyRyVMxIv/quRiw3SKJzAMOTBiAvFICpWuRFa+T/xIMHK0g96w/IMQo0jdY1E067ZEvBUOBmsJnGJg1LllS3rbJVe+E2ClFNL8SzFphyvtlcfvYB+SVSD4bzI0w/YCldv5Sq42BFt5bn4n4aE5A6658DYsfSRYWqP6OpqPJx96cY34W7H1t/ZG0ulez6zF5NvWhc1HDQ1gMtXd+K/ogt1n+FyFtn8xzvtSGkmrc2jJgYNI5Pd0Z0ent73z0MKbJx9v2ta/emPEzPr3cndN5amdr6TmRkDU4bq0vyhAh87DJrAnJQLdrvYLddnrr8xTdeXxj1i1Yug6SGncPh9sbTYkdOfuamPAYOuiJVBAMcfYsYEiQndZe8mOQ4bpCr+hxAAqixhZ16pQ8CeUwa247+D2scRymLB8qJXlaERuFZtWGVAZ8VP/GS/9EXjrzpjGX9vlrIPeJP8fh2S5QPzw55cGNJ7JfAdOyManXnoEw2/QzDhSZQARVl+akFgSO0Y13YmbiL7H6HcKWGcJ2ipDKIaj2fJ7GE0Vzyt+CBEezSQR99Igd8x3p2JtvsVKp35iLPksjS1VqtSCTbuIRUlINlfQHNjeQiE/B/61jo3Mf7SmjYjqtvXt5e9RKb+CQku2qH4ZU8xN3DSg+4mLom3BgKBkm/MoyGBpMK41c96d2tRp3tp4hV0F6ac02Crg7P2lw8IUct+i2VJ8VUjcbRfTIPQs0HjNjM6/gLfLCkWOHYrlFjwusXWQCJz91Kq+hVxj7M9LtplPO4AUq6RUMNhlPGUmyOI2tcUMrjq9vMLXGlfdkH185zM4Mk+O7DRLC8683lXZFZvcBEmxr855PqLLH/9SpYKHBoGRatDRdQe3oRp6gHS0jpQ1SW/si4kvLKiUNjiBExvbQVOUV7/VFXvG1RpM9wbzSoOd40gg7ZzD/72QshUC/25DkM/Pm7RBzwtjgmnRKjT+mROeC/7VQLoz3amv09O8Mvbt+h/lX5+51Q834F7NgIGagbB20WtWcMtrmKrvCEZlaoiZrmYVSbi1RfknRK7CTPJkopw9IjO7Ut2EhKZ+jL4rwk6TlVm6EC6Kuj7KNqp6wB/UNe9eM2Eym/aiHAcja8XN4YQhSIuJD2Wxb0n3LkKnAjK1/GY65c8K6rZsVYQ0MQL1j4lMl0UZPjG/vzKyetIsVDyXc4J9ZhOEMYnt/LaxEeSt4EMJGBA9wpTmz33X4h3ij0Y3DY/rH7lrEScUknw20swTZRm5T6q1bnimj7M1OiOkebdI09MZ0nyaTWRHdB7B52C/moh89Q7qa2Fulp5h8Us1FYRkWBLt37a5rGI1IfVeP38KaPbagND+XzWpNqX4HVrAVPLQVK5EwUvGamED3ooJ0FMieTc0IH0N+IeUYG7Q8XmrRVBcw32W8pEfYLO9L71An/J0jQZCIP8DuQnUG0mOvunOuloBGvP/9LvkBlkamh68F0a5f5ny1jloyIFJhRh5dt2SBlbsXS9AKqUwARYSSsA9Ao4WJWOZMyjp8A+qIBAfW65MdhhUDKYMBgIAbMCc3uiptzElQQopE5TT5xIhwfYxa503jVzQbz1Q==');

        try {
            Sealed::unsealEventResponse(
                $sealedResult,
                $this->keys
            );
        } catch (UnsealAggregateException $e) {
            /** @var UnsealException $error */
            $error = $e->getExceptions()[1];

            $this->assertInstanceOf(UnsealException::class, $error);

            $actualError = $error->getPrevious();

            $this->assertInstanceOf(DecompressionException::class, $actualError);
        }
    }

    /**
     * @throws UnsealAggregateException
     */
    public function testUnsealEventResponseWithInvalidHeader()
    {
        $sealedResult = base64_decode('noXc7xXO+mqeAGrvBMgObi/S0fXTpP3zupk8qFqsO/1zdtWCD169iLA3VkkZh9ICHpZ0oWRzqG0M9/TnCeKFohgBLqDp6O0zEfXOv6i5q++aucItznQdLwrKLP+O0blfb4dWVI8/aSbd4ELAZuJJxj9bCoVZ1vk+ShbUXCRZTD30OIEAr3eiG9aw00y1UZIqMgX6CkFlU9L9OnKLsNsyomPIaRHTmgVTI5kNhrnVNyNsnzt9rY7fUD52DQxJILVPrUJ1Q+qW7VyNslzGYBPG0DyYlKbRAomKJDQIkdj/Uwa6bhSTq4XYNVvbk5AJ/dGwvsVdOnkMT2Ipd67KwbKfw5bqQj/cw6bj8Cp2FD4Dy4Ud4daBpPRsCyxBM2jOjVz1B/lAyrOp8BweXOXYugwdPyEn38MBZ5oL4D38jIwR/QiVnMHpERh93jtgwh9Abza6i4/zZaDAbPhtZLXSM5ztdctv8bAb63CppLU541Kf4OaLO3QLvfLRXK2n8bwEwzVAqQ22dyzt6/vPiRbZ5akh8JB6QFXG0QJF9DejsIspKF3JvOKjG2edmC9o+GfL3hwDBiihYXCGY9lElZICAdt+7rZm5UxMx7STrVKy81xcvfaIp1BwGh/HyMsJnkE8IczzRFpLlHGYuNDxdLoBjiifrmHvOCUDcV8UvhSV+UAZtAVejdNGo5G/bz0NF21HUO4pVRPu6RqZIs/aX4hlm6iO/0Ru00ct8pfadUIgRcephTuFC2fHyZxNBC6NApRtLSNLfzYTTo/uSjgcu6rLWiNo5G7yfrM45RXjalFEFzk75Z/fu9lCJJa5uLFgDNxlU+IaFjArfXJCll3apbZp4/LNKiU35ZlB7ZmjDTrji1wLep8iRVVEGht/DW00MTok7Zn7Fv+MlxgWmbZB3BuezwTmXb/fNw==');

        $this->expectException(InvalidSealedDataHeaderException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    /**
     * @throws UnsealAggregateException
     */
    public function testUnsealEventResponseWithEmptyData()
    {
        $sealedResult = '';

        $this->expectException(InvalidSealedDataHeaderException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    public function testUnsealEventResponseWithInvalidKeys()
    {
        $sealedResult = base64_decode('noXc7SXO+mqeAGrvBMgObi/S0fXTpP3zupk8qFqsO/1zdtWCD169iLA3VkkZh9ICHpZ0oWRzqG0M9/TnCeKFohgBLqDp6O0zEfXOv6i5q++aucItznQdLwrKLP+O0blfb4dWVI8/aSbd4ELAZuJJxj9bCoVZ1vk+ShbUXCRZTD30OIEAr3eiG9aw00y1UZIqMgX6CkFlU9L9OnKLsNsyomPIaRHTmgVTI5kNhrnVNyNsnzt9rY7fUD52DQxJILVPrUJ1Q+qW7VyNslzGYBPG0DyYlKbRAomKJDQIkdj/Uwa6bhSTq4XYNVvbk5AJ/dGwvsVdOnkMT2Ipd67KwbKfw5bqQj/cw6bj8Cp2FD4Dy4Ud4daBpPRsCyxBM2jOjVz1B/lAyrOp8BweXOXYugwdPyEn38MBZ5oL4D38jIwR/QiVnMHpERh93jtgwh9Abza6i4/zZaDAbPhtZLXSM5ztdctv8bAb63CppLU541Kf4OaLO3QLvfLRXK2n8bwEwzVAqQ22dyzt6/vPiRbZ5akh8JB6QFXG0QJF9DejsIspKF3JvOKjG2edmC9o+GfL3hwDBiihYXCGY9lElZICAdt+7rZm5UxMx7STrVKy81xcvfaIp1BwGh/HyMsJnkE8IczzRFpLlHGYuNDxdLoBjiifrmHvOCUDcV8UvhSV+UAZtAVejdNGo5G/bz0NF21HUO4pVRPu6RqZIs/aX4hlm6iO/0Ru00ct8pfadUIgRcephTuFC2fHyZxNBC6NApRtLSNLfzYTTo/uSjgcu6rLWiNo5G7yfrM45RXjalFEFzk75Z/fu9lCJJa5uLFgDNKlU+IaFjArfXJCll3apbZp4/LNKiU35ZlB7ZmjDTrji1wLep8iRVVEGht/DW00MTok7Zn7Fv+MlxgWmbZB3BuezwTmXb/fNw==');

        $this->expectException(UnsealAggregateException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            [$this->keys[0]]
        );
    }

    public function testUnsealEventResponseWithInvalidNonce()
    {
        $sealedResult = "\x9E\x85\xDC\xED\xAA\xBB\xCC";

        $this->expectException(UnsealAggregateException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    /**
     * @throws UnsealAggregateException
     */
    public function testTypesAreDefinedCorrect()
    {
        $sealed = base64_decode(self::SEALED_RESULT);
        $unsealed = Sealed::unsealEventResponse($sealed, $this->keys);
        $ipLocation = $unsealed->getIpInfo()->getV4()->getGeolocation();
        $browserDetails = $unsealed->getBrowserDetails();
        $confidence = $unsealed->getIdentification()->getConfidence();
        $botResult = $unsealed->getBot();
        $this->assertEquals(Geolocation::class, get_class($ipLocation));
        $this->assertEquals(BrowserDetails::class, get_class($browserDetails));
        $this->assertEquals(IdentificationConfidence::class, get_class($confidence));
        $this->assertEquals(BotResult::NOT_DETECTED, $botResult);
    }
}
