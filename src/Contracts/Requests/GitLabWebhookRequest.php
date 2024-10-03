<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Contracts\Requests;

interface GitLabWebhookRequest
{
    /**
     * @return ($asResource is true ? resource : string)
     */
    public function getContent(bool $asResource = false);

    /**
     *
     * @param string|null $key
     * @param string|array<string|null>|null $default
     * @return string|array<string|null>|null
     */
    public function header($key = null, $default = null);
}
