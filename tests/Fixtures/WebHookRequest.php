<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests\Fixtures;

use Illuminate\Support\Arr;
use TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest;

class WebHookRequest implements GitLabWebhookRequest
{
    public $content = null;

    public array $headers = [];

    public function getContent()
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
        return Arr::get($this->headers, $key, $default);
    }
}
