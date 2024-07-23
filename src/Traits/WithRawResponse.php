<?php

namespace Fingerprint\ServerAPI\Traits;

trait WithRawResponse
{
    protected mixed $rawResponse = null;

    public function getRawResponse(): mixed
    {
        return $this->rawResponse;
    }

    public function setRawResponse(mixed $rawResponse): void
    {
        $this->rawResponse = $rawResponse;
    }
}
