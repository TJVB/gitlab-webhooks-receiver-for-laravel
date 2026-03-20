<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use TJVB\GitLabWebhooks\Contracts\Actions\InComingWebhookRequestStoring;
use TJVB\GitLabWebhooks\Exceptions\InvalidInputException;
use TJVB\GitLabWebhooks\Tests\Fixtures\WebHookStoring;

class WebhookReceiverTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    #[Test]
    public function weCanStoreAValidRequest(): void
    {
        // setup / mock
        $this->withoutMiddleware();
        $storing = new WebHookStoring();

        $this->app->instance(InComingWebhookRequestStoring::class, $storing);

        // run
        $response = $this->postJson(config('gitlab-webhooks-receiver.url', '/gitlabwebhook'), ['']);

        // verify/assert
        $response->assertCreated();
    }

    /**
     * @test
     */
    #[Test]
    public function weGetABadRequestIfWeHaveInvalidData(): void
    {
        // setup / mock
        $this->withoutMiddleware();
        $storing = new WebHookStoring();
        $storing->behaviour = static function () {
            throw new InvalidInputException('Test exception');
        };

        $this->app->instance(InComingWebhookRequestStoring::class, $storing);

        // run
        $response = $this->postJson(config('gitlab-webhooks-receiver.url', '/gitlabwebhook'), ['invalidjson']);

        // verify/assert
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertSee('Test exception');
    }

    /**
     * @test
     */
    #[Test]
    public function weGetAnInternalServerErrorIfWeHaveAnUnknownError(): void
    {
        // setup / mock
        $this->withoutMiddleware();
        $storing = new WebHookStoring();
        $storing->behaviour = static function () {
            throw new Exception('Test exception');
        };

        $this->app->instance(InComingWebhookRequestStoring::class, $storing);

        // run
        $response = $this->postJson(config('gitlab-webhooks-receiver.url', '/gitlabwebhook'), ['']);

        // verify/assert
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertSee('Failed to store webhook data');
    }
}
