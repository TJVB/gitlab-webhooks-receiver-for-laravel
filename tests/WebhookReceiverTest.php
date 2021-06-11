<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Tests\Fixtures\WebHookStoring;

class WebhookReceiverTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function weCanStoreAValidRequest(): void
    {
        // setup / mock
        $storing = new WebHookStoring();

        $this->app->instance(InComingWebhookRequestStoring::class, $storing);

        // run
        $response = $this->post(config('gitlab-webhooks-receiver.url', '/gitlabwebhook'), ['']);

        // verify/assert
        $response->assertCreated();
    }

    /**
     * @test
     */
    public function weGetABadRequestIfWeHaveInvalidData(): void
    {
        // setup / mock

        // run
        $response = $this->post(config('gitlab-webhooks-receiver.url', '/gitlabwebhook'), ['invalidjson']);

        // verify/assert
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function weGetAnInternalServerErrorIfWeHaveAnUnknownError(): void
    {
        // setup / mock
        $storing = new WebHookStoring();
        $storing->behaviour = static function () {
            throw new Exception('Test exception');
        };

        $this->app->instance(InComingWebhookRequestStoring::class, $storing);

        // run
        $response = $this->post(config('gitlab-webhooks-receiver.url', '/gitlabwebhook'), ['']);

        // verify/assert
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
