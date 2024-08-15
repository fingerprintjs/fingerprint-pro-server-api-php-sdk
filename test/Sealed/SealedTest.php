<?php

namespace Fingerprint\ServerAPI\Sealed;

use Fingerprint\ServerAPI\Model\EventResponse;
use Fingerprint\ServerAPI\ObjectSerializer;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SealedTest extends TestCase
{
    /**
     * @var string
     */
    protected $validKey;

    /**
     * @var string
     */
    protected $invalidKey;

    /**
     * @var DecryptionKey[]
     */
    protected $keys;

    protected function setUp(): void
    {
        $this->validKey = base64_decode("p2PA7MGy5tx56cnyJaFZMr96BCFwZeHjZV2EqMvTq53=");
        $this->invalidKey = base64_decode("p2PA7MGy5tx56cnyJaFZMr96BCFwZeHjZV2EqMvTq54=");

        $this->keys = [
            new DecryptionKey($this->invalidKey, DecryptionAlgorithm::AES_256_GCM),
            new DecryptionKey($this->validKey, DecryptionAlgorithm::AES_256_GCM)
        ];
    }

    public function testUnsealEventResponse()
    {
        $sealedResult = base64_decode("noXc7SXO+mqeAGrvBMgObi/S0fXTpP3zupk8qFqsO/1zdtWCD169iLA3VkkZh9ICHpZ0oWRzqG0M9/TnCeKFohgBLqDp6O0zEfXOv6i5q++aucItznQdLwrKLP+O0blfb4dWVI8/aSbd4ELAZuJJxj9bCoVZ1vk+ShbUXCRZTD30OIEAr3eiG9aw00y1UZIqMgX6CkFlU9L9OnKLsNsyomPIaRHTmgVTI5kNhrnVNyNsnzt9rY7fUD52DQxJILVPrUJ1Q+qW7VyNslzGYBPG0DyYlKbRAomKJDQIkdj/Uwa6bhSTq4XYNVvbk5AJ/dGwvsVdOnkMT2Ipd67KwbKfw5bqQj/cw6bj8Cp2FD4Dy4Ud4daBpPRsCyxBM2jOjVz1B/lAyrOp8BweXOXYugwdPyEn38MBZ5oL4D38jIwR/QiVnMHpERh93jtgwh9Abza6i4/zZaDAbPhtZLXSM5ztdctv8bAb63CppLU541Kf4OaLO3QLvfLRXK2n8bwEwzVAqQ22dyzt6/vPiRbZ5akh8JB6QFXG0QJF9DejsIspKF3JvOKjG2edmC9o+GfL3hwDBiihYXCGY9lElZICAdt+7rZm5UxMx7STrVKy81xcvfaIp1BwGh/HyMsJnkE8IczzRFpLlHGYuNDxdLoBjiifrmHvOCUDcV8UvhSV+UAZtAVejdNGo5G/bz0NF21HUO4pVRPu6RqZIs/aX4hlm6iO/0Ru00ct8pfadUIgRcephTuFC2fHyZxNBC6NApRtLSNLfzYTTo/uSjgcu6rLWiNo5G7yfrM45RXjalFEFzk75Z/fu9lCJJa5uLFgDNKlU+IaFjArfXJCll3apbZp4/LNKiU35ZlB7ZmjDTrji1wLep8iRVVEGht/DW00MTok7Zn7Fv+MlxgWmbZB3BuezwTmXb/fNw==");

        $response = new Response(200, [], "{\"products\":{\"identification\":{\"data\":{\"visitorId\":\"2ZEDCZEfOfXjEmMuE3tq\",\"requestId\":\"1703067132750.Z5hutJ\",\"browserDetails\":{\"browserName\":\"Safari\",\"browserMajorVersion\":\"17\",\"browserFullVersion\":\"17.3\",\"os\":\"Mac OS X\",\"osVersion\":\"10.15.7\",\"device\":\"Other\",\"userAgent\":\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3 Safari/605.1.15\"},\"incognito\":false,\"ip\":\"::1\",\"ipLocation\":{\"accuracyRadius\":1000,\"latitude\":59.3241,\"longitude\":18.0517,\"postalCode\":\"100 05\",\"timezone\":\"Europe/Stockholm\",\"city\":{\"name\":\"Stockholm\"},\"country\":{\"code\":\"SE\",\"name\":\"Sweden\"},\"continent\":{\"code\":\"EU\",\"name\":\"Europe\"},\"subdivisions\":[{\"isoCode\":\"AB\",\"name\":\"Stockholm County\"}]},\"timestamp\":1703067136286,\"time\":\"2023-12-20T10:12:16Z\",\"url\":\"http://localhost:8080/\",\"tag\":{\"foo\":\"bar\"},\"confidence\":{\"score\":1},\"visitorFound\":true,\"firstSeenAt\":{\"global\":\"2023-12-15T12:13:55.103Z\",\"subscription\":\"2023-12-15T12:13:55.103Z\"},\"lastSeenAt\":{\"global\":\"2023-12-19T11:39:51.52Z\",\"subscription\":\"2023-12-19T11:39:51.52Z\"}}},\"botd\":{\"data\":{\"bot\":{\"result\":\"notDetected\"},\"meta\":{\"foo\":\"bar\"},\"url\":\"http://localhost:8080/\",\"ip\":\"::1\",\"time\":\"2023-12-20T10:12:13.894Z\",\"userAgent\":\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3 Safari/605.1.15\",\"requestId\":\"1703067132750.Z5hutJ\"}}}}");

        $expectedResponse = ObjectSerializer::deserialize($response, EventResponse::class);

        $eventResponse = Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );

        $this->assertEquals($expectedResponse, $eventResponse);
    }

    public function testUnsealEventResponseWithInvalidSealedResult()
    {
        // "{\"invalid\":true}"
        $sealedResult = base64_decode("noXc7VOpBstjjcavDKSKr4HTavt4mdq8h6NC32T0hUtw9S0jXT8lPjZiWL8SyHxmrF3uTGqO+g==");

        $this->expectException(InvalidSealedDataException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    public function testUnsealEventResponseWithInvalidJsonSealedResult()
    {
        $sealedResult = base64_decode("noXc7XdbEp5JpFNJaMxCB5leuFeW9Fs0tqvwnbU3ND2yShYn+dgeUWvdk32YrXam4yuvhmpO8gww//Qmsu2sbyvyMRuXmlKoriV9EVPYVCB2xszskg34ngrAh4sreRZV3c8d0DcXZulbMiiXrli931fEABWRHM0NtcoPuubqb+TysNSoFIYVZxpRVDR8jDiTXuQyPzvqBJD4+xeQTOOAOjPlqRTQSSBrlWjeZLNA70wWX7VRDXA1SoR+1k7bkBFK4OwRnh5rVGeGvGeHisOe/SyOL6GlQyBk3sRdSCQiI/g0ywdqLsOk4xDdCgg5vMI07APvL9FSaQrglMvD8NRmQOr5glZoV6S3DoBgaYQVvEygTZy2gfJ0z6hLY6Q8WSW0hpb3t9m4MP9WC5Vc2r0fmfqX7gjYZpwyfJxsyyk4iksminhm2T8N8DTYuZuz82jjaGNDqAPn1PZKqiEh8H9TpcgewAP8mlVrB5CUPJMHH+p7dM5zibfKM9+1MPxvZNp0PBkljBwrfGjiKlmYhn7bb5UW5TeEMtiP27KoA26PX+NV130Vi9Y/LUgMivLwaIc+jnlFyaoqg6Kg6H8G3WhT0r/pc4KP0mwyHJzfXjep8kQZGKxbMd0Sc3h4kpoWR1hdYM4QZRvKQzh7BqBPtPiVgHYoEJf9qFVxYhel9UFONz65q5bA2Y25oFKpzfsiXQqFEo/LRANnW7iUdfesGtGjjP4N6rd8ssNpYf57FmPBpWC4RwjG45MHRUSajCVLKiwUgFQbOo7/t5hgQIQOui3jmCBDjCjpjGZK8vd2nFputUTqI/MmZK7THaDPFsn8h9M1boF3VMCzDXygJFhd5lwdVErXGtQcc1lApEvdOr24QB5Io4SjfjJCfEQ7g4ulBXuqsh6I4VkcuMh5zgBIdmGm");

        $this->expectException(InvalidSealedDataException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    public function testUnsealEventResponseWithNotCompressedSealedResult()
    {
        $sealedResult = base64_decode("noXc7dtuk0smGE+ZbaoXzrp6Rq8ySxLepejTsu7+jUXlPhV1w+WuHx9gbPhaENJnOQo8BcGmsaRhL5k2NVj+DRNzYO9cQD7wHxmXKCyTbl/dvSYOMoHziUZ2VbQ7tmaorFny26v8jROr/UBGfvPE0dLKC36IN9ZlJ3X0NZJO8SY+8bCr4mTrkVZsv/hpvZp+OjC4h7e5vxcpmnBWXzxfaO79Lq3aMRIEf9XfK7/bVIptHaEqtPKCTwl9rz1KUpUUNQSHTPM0NlqJe9bjYf5mr1uYvWHhcJoXSyRyVMxIv/quRiw3SKJzAMOTBiAvFICpWuRFa+T/xIMHK0g96w/IMQo0jdY1E067ZEvBUOBmsJnGJg1LllS3rbJVe+E2ClFNL8SzFphyvtlcfvYB+SVSD4bzI0w/YCldv5Sq42BFt5bn4n4aE5A6658DYsfSRYWqP6OpqPJx96cY34W7H1t/ZG0ulez6zF5NvWhc1HDQ1gMtXd+K/ogt1n+FyFtn8xzvtSGkmrc2jJgYNI5Pd0Z0ent73z0MKbJx9v2ta/emPEzPr3cndN5amdr6TmRkDU4bq0vyhAh87DJrAnJQLdrvYLddnrr8xTdeXxj1i1Yug6SGncPh9sbTYkdOfuamPAYOuiJVBAMcfYsYEiQndZe8mOQ4bpCr+hxAAqixhZ16pQ8CeUwa247+D2scRymLB8qJXlaERuFZtWGVAZ8VP/GS/9EXjrzpjGX9vlrIPeJP8fh2S5QPzw55cGNJ7JfAdOyManXnoEw2/QzDhSZQARVl+akFgSO0Y13YmbiL7H6HcKWGcJ2ipDKIaj2fJ7GE0Vzyt+CBEezSQR99Igd8x3p2JtvsVKp35iLPksjS1VqtSCTbuIRUlINlfQHNjeQiE/B/61jo3Mf7SmjYjqtvXt5e9RKb+CQku2qH4ZU8xN3DSg+4mLom3BgKBkm/MoyGBpMK41c96d2tRp3tp4hV0F6ac02Crg7P2lw8IUct+i2VJ8VUjcbRfTIPQs0HjNjM6/gLfLCkWOHYrlFjwusXWQCJz91Kq+hVxj7M9LtplPO4AUq6RUMNhlPGUmyOI2tcUMrjq9vMLXGlfdkH185zM4Mk+O7DRLC8683lXZFZvcBEmxr855PqLLH/9SpYKHBoGRatDRdQe3oRp6gHS0jpQ1SW/si4kvLKiUNjiBExvbQVOUV7/VFXvG1RpM9wbzSoOd40gg7ZzD/72QshUC/25DkM/Pm7RBzwtjgmnRKjT+mROeC/7VQLoz3amv09O8Mvbt+h/lX5+51Q834F7NgIGagbB20WtWcMtrmKrvCEZlaoiZrmYVSbi1RfknRK7CTPJkopw9IjO7Ut2EhKZ+jL4rwk6TlVm6EC6Kuj7KNqp6wB/UNe9eM2Eym/aiHAcja8XN4YQhSIuJD2Wxb0n3LkKnAjK1/GY65c8K6rZsVYQ0MQL1j4lMl0UZPjG/vzKyetIsVDyXc4J9ZhOEMYnt/LaxEeSt4EMJGBA9wpTmz33X4h3ij0Y3DY/rH7lrEScUknw20swTZRm5T6q1bnimj7M1OiOkebdI09MZ0nyaTWRHdB7B52C/moh89Q7qa2Fulp5h8Us1FYRkWBLt37a5rGI1IfVeP38KaPbagND+XzWpNqX4HVrAVPLQVK5EwUvGamED3ooJ0FMieTc0IH0N+IeUYG7Q8XmrRVBcw32W8pEfYLO9L71An/J0jQZCIP8DuQnUG0mOvunOuloBGvP/9LvkBlkamh68F0a5f5ny1jloyIFJhRh5dt2SBlbsXS9AKqUwARYSSsA9Ao4WJWOZMyjp8A+qIBAfW65MdhhUDKYMBgIAbMCc3uiptzElQQopE5TT5xIhwfYxa503jVzQbz1Q==");

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

    public function testUnsealEventResponseWithInvalidHeader()
    {
        $sealedResult = base64_decode("noXc7xXO+mqeAGrvBMgObi/S0fXTpP3zupk8qFqsO/1zdtWCD169iLA3VkkZh9ICHpZ0oWRzqG0M9/TnCeKFohgBLqDp6O0zEfXOv6i5q++aucItznQdLwrKLP+O0blfb4dWVI8/aSbd4ELAZuJJxj9bCoVZ1vk+ShbUXCRZTD30OIEAr3eiG9aw00y1UZIqMgX6CkFlU9L9OnKLsNsyomPIaRHTmgVTI5kNhrnVNyNsnzt9rY7fUD52DQxJILVPrUJ1Q+qW7VyNslzGYBPG0DyYlKbRAomKJDQIkdj/Uwa6bhSTq4XYNVvbk5AJ/dGwvsVdOnkMT2Ipd67KwbKfw5bqQj/cw6bj8Cp2FD4Dy4Ud4daBpPRsCyxBM2jOjVz1B/lAyrOp8BweXOXYugwdPyEn38MBZ5oL4D38jIwR/QiVnMHpERh93jtgwh9Abza6i4/zZaDAbPhtZLXSM5ztdctv8bAb63CppLU541Kf4OaLO3QLvfLRXK2n8bwEwzVAqQ22dyzt6/vPiRbZ5akh8JB6QFXG0QJF9DejsIspKF3JvOKjG2edmC9o+GfL3hwDBiihYXCGY9lElZICAdt+7rZm5UxMx7STrVKy81xcvfaIp1BwGh/HyMsJnkE8IczzRFpLlHGYuNDxdLoBjiifrmHvOCUDcV8UvhSV+UAZtAVejdNGo5G/bz0NF21HUO4pVRPu6RqZIs/aX4hlm6iO/0Ru00ct8pfadUIgRcephTuFC2fHyZxNBC6NApRtLSNLfzYTTo/uSjgcu6rLWiNo5G7yfrM45RXjalFEFzk75Z/fu9lCJJa5uLFgDNxlU+IaFjArfXJCll3apbZp4/LNKiU35ZlB7ZmjDTrji1wLep8iRVVEGht/DW00MTok7Zn7Fv+MlxgWmbZB3BuezwTmXb/fNw==");

        $this->expectException(InvalidSealedDataHeaderException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    public function testUnsealEventResponseWithEmptyData()
    {
        $sealedResult = "";

        $this->expectException(InvalidSealedDataHeaderException::class);

        Sealed::unsealEventResponse(
            $sealedResult,
            $this->keys
        );
    }

    public function testUnsealEventResponseWithInvalidKeys()
    {
        $sealedResult = base64_decode("noXc7SXO+mqeAGrvBMgObi/S0fXTpP3zupk8qFqsO/1zdtWCD169iLA3VkkZh9ICHpZ0oWRzqG0M9/TnCeKFohgBLqDp6O0zEfXOv6i5q++aucItznQdLwrKLP+O0blfb4dWVI8/aSbd4ELAZuJJxj9bCoVZ1vk+ShbUXCRZTD30OIEAr3eiG9aw00y1UZIqMgX6CkFlU9L9OnKLsNsyomPIaRHTmgVTI5kNhrnVNyNsnzt9rY7fUD52DQxJILVPrUJ1Q+qW7VyNslzGYBPG0DyYlKbRAomKJDQIkdj/Uwa6bhSTq4XYNVvbk5AJ/dGwvsVdOnkMT2Ipd67KwbKfw5bqQj/cw6bj8Cp2FD4Dy4Ud4daBpPRsCyxBM2jOjVz1B/lAyrOp8BweXOXYugwdPyEn38MBZ5oL4D38jIwR/QiVnMHpERh93jtgwh9Abza6i4/zZaDAbPhtZLXSM5ztdctv8bAb63CppLU541Kf4OaLO3QLvfLRXK2n8bwEwzVAqQ22dyzt6/vPiRbZ5akh8JB6QFXG0QJF9DejsIspKF3JvOKjG2edmC9o+GfL3hwDBiihYXCGY9lElZICAdt+7rZm5UxMx7STrVKy81xcvfaIp1BwGh/HyMsJnkE8IczzRFpLlHGYuNDxdLoBjiifrmHvOCUDcV8UvhSV+UAZtAVejdNGo5G/bz0NF21HUO4pVRPu6RqZIs/aX4hlm6iO/0Ru00ct8pfadUIgRcephTuFC2fHyZxNBC6NApRtLSNLfzYTTo/uSjgcu6rLWiNo5G7yfrM45RXjalFEFzk75Z/fu9lCJJa5uLFgDNKlU+IaFjArfXJCll3apbZp4/LNKiU35ZlB7ZmjDTrji1wLep8iRVVEGht/DW00MTok7Zn7Fv+MlxgWmbZB3BuezwTmXb/fNw==");

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
}
