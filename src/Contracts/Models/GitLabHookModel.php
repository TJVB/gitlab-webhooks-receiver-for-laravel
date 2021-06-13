<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Contracts\Models;

interface GitLabHookModel
{
    public function isSystemHook(): bool;
}
