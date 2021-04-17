<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::any(config('gitlab-webhooks-receiver.url', '/gitlabwebhook'),
    config('gitlab-webhooks-receiver.controller', \TJVB\GitLabWebhooks\Http\Controllers\GitLabWebhookController::class))
    ->name(config('gitlab-webhooks-receiver.name', 'gitlabwebhookreceiver'))
    ->middleware(config('gitlab-webhooks-receiver.middleware', []))
    ;