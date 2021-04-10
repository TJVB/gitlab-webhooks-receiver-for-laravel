<?php
declare(strict_types=1);
return [

    /**
     * Routing part for the webhook, this decided the controller and middleware and route that receive the webhook
     */
    'controller' => \TJVB\GitLabWebhooks\Http\Controllers\GitLabWebhookController::class,
    'middleware' => [],
    'url' => 'gitlabwebhook',
    'name' => 'gitlabwebhookreceiver',


];