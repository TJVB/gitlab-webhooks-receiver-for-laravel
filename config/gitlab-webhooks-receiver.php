<?php
declare(strict_types=1);
return [

    /**
     * Routing part for the webhook, this decided the controller and middleware and route that receive the webhook
     */
    'controller' => \TJVB\GitLabWebhooks\Http\Controllers\GitLabWebhookController::class,
    // The request need to implement \TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest
    'request' => \TJVB\GitLabWebhooks\Http\Requests\GitLabWebhookRequest::class,
    'middleware' => [
        \TJVB\GitLabWebhooks\Http\Middleware\EnsureSecretTokenIsValid::class,
    ],
    'url' => 'gitlabwebhook',
    'name' => 'gitlabwebhookreceiver',

    /**
     * A list with valid secrets for the webhooks, a secret can be added to the webhook.
     * See: https://docs.gitlab.com/ee/user/project/integrations/webhooks.html#secret-token
     */
    'valid_secrets' => [
        env('GITLAB_WEBHOOK_SECRET'),
    ],


    /**
     * The actions that does one thing and one thing only
     */
    'store_request_action' => \TJVB\GitLabWebhooks\Actions\StoreInComingWebhookRequestData::class,

    /**
     * The model that represent the data
     */
    'hook_model' => \TJVB\GitLabWebhooks\Models\GitLabHook::class,

    /**
     * The dispatched event if an hook is stored
     */
    'hook_stored_event' => \TJVB\GitLabWebhooks\Events\HookStored::class,

];