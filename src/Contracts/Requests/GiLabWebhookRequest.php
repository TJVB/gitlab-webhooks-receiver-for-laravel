<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Contracts\Requests;

interface GiLabWebhookRequest
{
    public function getContent();

    /**
     * Retrieve a header from the request.
     *
     * @param  string|null  $key
     * @param  string|array|null  $default
     * @return string|array|null
     */
    public function header($key = null, $default = null);
}
