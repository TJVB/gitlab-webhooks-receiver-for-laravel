<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Actions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Safe\Exceptions\JsonException;
use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Contracts\Events\GitLabHookStored;
use TJVB\GitLabWebhooks\Contracts\Models\GitLabHookModel;
use TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;
use function Safe\json_decode;

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
            /** @var array<string> $body */
            $body = json_decode($content, true);
        } catch (JsonException $jsonException) {
            throw InvalidInputException::fromJsonException($jsonException);
        }
        $gitLabHookModel = $this->createHookModel($body, $request);
        /** @var GitLabHookStored $event */
        $event = $this->container->make(GitLabHookStored::class, [
            'model' => $gitLabHookModel
        ]);
        $this->dispatcher->dispatch($event);
    }

    /**
     * @param array<string> $body
     */
    private function createHookModel(array $body, GitLabWebhookRequest $request): GitLabHookModel
    {
        /** @var GitLabHookModel $model */
        $model = $this->container->make(GitLabHookModel::class);
        return $model->store(
            $body,
            $body['event_name'] ?? '',
            $body['event_type'] ?? '',
            $body['object_kind'] ?? '',
            $request->header('X-Gitlab-Event') === 'System Hook'
        );
    }
}
