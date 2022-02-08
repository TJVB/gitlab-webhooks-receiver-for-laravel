<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks;

use Illuminate\Support\ServiceProvider;
use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Contracts\Events\GitLabHookStored;
use TJVB\GitLabWebhooks\Contracts\Models\GitLabHookModel;
use TJVB\GitLabWebhooks\Contracts\Requests\GitLabWebhookRequest;

class GitLabWebhooksServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/gitlab-webhooks-receiver.php' => \config_path('gitlab-webhooks-receiver.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/gitlab-webhooks-receiver.php', 'gitlab-webhooks-receiver');

        $this->app->bind(GitLabWebhookRequest::class, config('gitlab-webhooks-receiver.request'));
        $this->app->bind(InComingWebhookRequestStoring::class, config('gitlab-webhooks-receiver.store_request_action'));
        $this->app->bind(GitLabHookModel::class, config('gitlab-webhooks-receiver.hook_model'));
        $this->app->bind(GitLabHookStored::class, config('gitlab-webhooks-receiver.hook_stored_event'));
    }
}
