<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Contracts\Actions;

use TJVB\GitLabWebhooks\Exceptions\Exception;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;
use TJVB\GitLabWebhooks\Http\Requests\GitLabWebhookRequest;

interface InComingWebhookRequestStoring
{
    /**
     * @param GitLabWebhookRequest $request
     *
     * @throws InvalidInputException
     * @throws Exception
     */
    public function handle(GitLabWebhookRequest $request): void;
}
