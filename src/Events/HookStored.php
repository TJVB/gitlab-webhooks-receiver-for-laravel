<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use TJVB\GitLabWebhooks\Contracts\Events\GitLabHookStored;
use TJVB\GitLabWebhooks\Contracts\Models\GitLabHookModel;

class HookStored implements GitLabHookStored
{
    use Dispatchable;
    use SerializesModels;

    public GitLabHookModel $model;

    public function __construct(GitLabHookModel $model)
    {
        $this->model = $model;
    }

    public function getHook(): GitLabHookModel
    {
        return $this->model;
    }
}
