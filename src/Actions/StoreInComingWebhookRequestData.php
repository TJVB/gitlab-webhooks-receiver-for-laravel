<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Actions;

use Illuminate\Support\Arr;
use JsonException;
use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;
use TJVB\GitLabWebhooks\Http\Requests\GitLabWebhookRequest;
use TJVB\GitLabWebhooks\Models\GitLabHook;

class StoreInComingWebhookRequestData implements InComingWebhookRequestStoring
{

    public function handle(GitLabWebhookRequest $request): void
    {
        try {
            $content = $request->getContent();
            $body = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw InvalidInputException::fromJsonException($jsonException);
        }
        $hook = $this->createHook($body, $request);
        unset($hook);
    }

    private function createHook(array $body, GitLabWebhookRequest $request)
    {
        $data = [
            'body' => $body,
            'object_kind' => Arr::get($body, 'object_kind'),
            'event_type' => Arr::get($body, 'event_type'),
            'event_name' => Arr::get($body, 'event_name'),
            'system_hook' => $request->header('X-Gitlab-Event') === 'System Hook',
        ];
        return GitLabHook::create($data);
    }
}
