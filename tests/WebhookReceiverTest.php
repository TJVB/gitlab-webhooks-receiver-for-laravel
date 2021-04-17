<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;

class WebhookReceiverTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function weCanStoreAValidRequest(): void
    {
        $this->markTestIncomplete('TODO');
        // setup / mock

        // run

        // verify/assert
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
        $this->markTestIncomplete('TODO');
        // setup / mock

        // run

        // verify/assert
    }
}
