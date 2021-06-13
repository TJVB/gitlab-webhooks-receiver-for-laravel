<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Actions;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;
use JsonException;
use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Contracts\Events\GitLabHookStored;
use TJVB\GitLabWebhooks\Contracts\Models\GitLabHookModel;
use TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;

class StoreInComingWebhookRequestData implements InComingWebhookRequestStoring
{
    private Container $container;
    private Dispatcher $dispatcher;

    public function __construct(Container $container, Dispatcher $dispatcher)
    {
        $this->container = $container;
        $this->dispatcher = $dispatcher;
    }

    public function handle(GitLabWebhookRequest $request): void
    {
        try {
            $content = $request->getContent();
            $body = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw InvalidInputException::fromJsonException($jsonException);
        }
        $hook = $this->createHook($body, $request);
        $event = $this->container->make(GitLabHookStored::class, [
            'model' => $hook
        ]);
        $this->dispatcher->dispatch($event);
    }

    private function createHook(array $body, GitLabWebhookRequest $request): GitLabHookModel
    {
        $model = $this->container->make(GitLabHookModel::class);
        $model->body = $body;
        $model->object_kind = Arr::get($body, 'object_kind');
        $model->event_type = Arr::get($body, 'event_type');
        $model->event_name = Arr::get($body, 'event_name');
        $model->system_hook = $request->header('X-Gitlab-Event') === 'System Hook';
        $model->save();
        return $model;
    }
}
