<?php

declare(strict_types=1);

namespace TJVB\GitLabWebhooks\Tests;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\JsonResponse;
use stdClass;
use TJVB\GitLabWebhooks\Http\Middleware\EnsureSecretTokenIsValid;
use TJVB\GitLabWebhooks\Tests\Fixtures\WebHookRequest;

class WebhookMiddlewareTest extends TestCase
{
    /**
     * @test
     */
    public function weHandleAValidRequest(): void
    {
        // setup / mock
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->set('gitlab-webhooks-receiver.valid_secrets', ['valid']);
        $middleware = new EnsureSecretTokenIsValid($config);
        $request = new WebHookRequest();
        $request->headers['X-Gitlab-Token'] = 'valid';

        // run
        $result = $middleware->handle($request, $this->getNextClosure());

        // verify/assert
        $this->assertNotInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function weHandleARequestWithoutToken(): void
    {
        // setup / mock
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $middleware = new EnsureSecretTokenIsValid($config);
        $request = new WebHookRequest();

        // run
        $result = $middleware->handle($request, $this->getNextClosure());

        // verify/assert
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $result->status());
        $this->assertStringContainsString('invalid token', (string) $result->getContent());
    }

    /**
     * @test
     */
    public function weHandleAnInvalidToken(): void
    {
        // setup / mock
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->set('gitlab-webhooks-receiver.valid_secrets', ['valid']);
        $middleware = new EnsureSecretTokenIsValid($config);
        $request = new WebHookRequest();
        $request->headers['X-Gitlab-Token'] = 'invalid';

        // run
        $result = $middleware->handle($request, $this->getNextClosure());

        // verify/assert
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $result->status());
        $this->assertStringContainsString('invalid token', (string) $result->getContent());
    }

    /**
     * @test
     */
    public function weHandleARequestThatDoesntHaveTheHeaderFunction(): void
    {
        // setup / mock
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->set('gitlab-webhooks-receiver.valid_secrets', ['valid']);
        $middleware = new EnsureSecretTokenIsValid($config);
        $request = new stdClass();

        // run
        $result = $middleware->handle($request, $this->getNextClosure());

        // verify/assert
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $result->status());
        $this->assertStringContainsString('invalid token', (string) $result->getContent());
    }

    private function getNextClosure(): Closure
    {
        return static function () {
            return true;
        };
    }
}
