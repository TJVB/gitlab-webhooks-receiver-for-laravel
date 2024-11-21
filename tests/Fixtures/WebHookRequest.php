<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests\Fixtures;

use TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest;

class WebHookRequest implements GitLabWebhookRequest
{
    public string $content = '';

    /** @var array<string, string> */
    public array $headers = [];

    public function getContent(bool $asResource = false)
    {
        if (is_callable($this->content)) {
            return call_user_func($this->content);
        }
        return $this->content;
    }

    public function header($key = null, $default = null)
    {
        if ($key === null) {
            return $this->headers;
        }
        return $this->headers[$key] ?? $default;
    }
}
