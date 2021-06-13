<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Contracts\Events;

use TJVB\GitLabWebhooks\Contracts\Models\GitLabHookModel;

interface GitLabHookStored
{
    public function __construct(GitLabHookModel $model);

    public function getHook(): GitLabHookModel;
}
