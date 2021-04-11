<?php
declare(strict_types=1);
return [

    /**
     * Routing part for the webhook, this decided the controller and middleware and route that receive the webhook
     */
    'controller' => \TJVB\GitLabWebhooks\Http\Controllers\GitLabWebhookController::class,
    // The request need to implement \TJVB\GitLabWebhooks\Contracts\Requests\GiLabWebhookRequest
    'request' => \TJVB\GitLabWebhooks\Http\Requests\GitLabWebhookRequest::class,
    'middleware' => [],
    'url' => 'gitlabwebhook',
    'name' => 'gitlabwebhookreceiver',


];