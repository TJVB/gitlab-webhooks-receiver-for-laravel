<?php
declare(strict_types=1);
return [

    /**
     * Routing part for the webhook, this decided the controller and middleware and route that receive the webhook
     */
    'controller' => \TJVB\GitLabWebhooks\Http\Controllers\GitLabWebhookController::class,
    // The request need to implement \TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest
    'request' => \TJVB\GitLabWebhooks\Http\Requests\GitLabWebhookRequest::class,
    'middleware' => [],
    'url' => 'gitlabwebhook',
    'name' => 'gitlabwebhookreceiver',


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