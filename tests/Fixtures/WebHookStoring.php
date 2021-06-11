<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests\Fixtures;

use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest;

class WebHookStoring implements InComingWebhookRequestStoring
{

    public $behaviour = null;

    /**
     * @inheritDoc
     */
    public function handle(GitLabWebhookRequest $request): void
    {
        if (is_callable($this->behaviour)) {
            call_user_func($this->behaviour);
        }
    }
}
