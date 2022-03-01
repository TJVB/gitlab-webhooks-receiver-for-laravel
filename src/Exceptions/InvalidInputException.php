<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Exceptions;

use Safe\Exceptions\JsonException;

class InvalidInputException extends Exception
{
    public static function fromJsonException(JsonException $jsonException): self
    {
        return new self('Unable to parse the JSON', $jsonException->getCode(), $jsonException);
    }
}
